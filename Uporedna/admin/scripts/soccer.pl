use strict;
use LWP::Simple;
use DBI;
use DBD::mysql;
use Switch;
use POSIX qw(strftime);

print strftime('%H:%M:%s',localtime),"\t Pocinjem skidanje kvota Soccer kladionice, Nek nam je sa srecom :) \n";

my $dsn= 'dbi:mysql:Uporedna_new:192.168.180.124:3306';
my $user = 'proske';
my $pass='proske1989'; 

my $konekcija = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

print strftime('%H:%M:%s',localtime),"\tCistim ulazne tabele \n";

my $upit=$konekcija->prepare("delete from ulaz_new;"); 
my $upit1=$konekcija->prepare("delete from ulaz_odds;"); 
$upit->execute or die "ne moze da se izvrsi";
$upit1->execute or die "ne moze da se izvrsi";

$konekcija->disconnect;

my $source_id = 2;
my $j=0;
my $home_team_id;
my $visitor_team_id;
my $liga_id;
my $sifra_id;
my @odds;
my @matches;
my @special_code_values = ('tim','tim po', 'moji_mecevi','sifra','45 no_kv pr','90 no_kv po');

print strftime('%H:%M:%s',localtime),"\t Skidam ponudu :\n";

my $tabele = get('http://www.kladionicasoccer.com/kvote/') or  "ne moze da skine stranicu";
while($tabele =~m{<tr class="kvote_h1"><th colspan="5" class="po">(.+?)</th>(.+?)</table>}gs)
{
	my $liga = $1;
	my $odds = $2;
	
	$liga_id = $liga;
	$liga_id=~s/\s+/_/g;

	while ($odds =~m{"kvote_row\s+(even|odd)\s+mec_(.+?)">(.+?)</tr>}gs)
	{
		my $sifra = $2;
		my $odds1 = $3;
		my $home_team= ""; my $visitor_team = ""; my $date ="";

		
		while($odds1=~m{<td class="(.+?)">(.+?)</td>}gs)
		{
			my $kod = $1;
			my $value = $2;
			
			if($kod ~~ @special_code_values) {
				switch ($kod)
				{
					case "tim" {$home_team = $value;$home_team =~s/\;+//g;$home_team =~s/\,+//g; $home_team =~s/\:+//g; $home_team =~s/\.+$//g;$home_team_id = $home_team; $home_team_id=~s/\s+/_/g;}
					case "tim po" {$visitor_team = $value;$visitor_team=~s/\;+//g;$visitor_team=~s/\,+//g;$visitor_team=~s/\:+//g;$visitor_team=~s/\.+$//g; $visitor_team_id = $visitor_team;$visitor_team_id=~s/\s+/_/g;}
				}
			}
			elsif($kod =~ 'pocetak')
			{
				$kod =~m{pocetak\s+(.+?)_(.+?)_(.+?)_(.+?)_(.+?)_.+?};
				my $year =$1;
				my $month=$2;
				my $day = $3;
				my $hour = $4;
				my $minute = $5;
				
				$date = $year."-".$month."-".$day." ".$hour.":".$minute,"\n";
			}
			
			else {
			
			$sifra_id = $liga_id.$home_team_id.$visitor_team_id;	
			$odds[$j][0]=$liga;
			$odds[$j][1]=$liga_id.$home_team_id.$visitor_team_id;
			$odds[$j][2]=$kod;
			$odds[$j][3]=$value;
					
			$j++;
			}
		}
		
		
		if ($sifra_id ~~ @matches) {
			
		}
		 else {
		 	my $n = scalar @matches;
		 	
			$matches[$n][0] = $liga_id;	 	
		 	$matches[$n][1] = $liga;
		 	$matches[$n][2] = $date;
		 	$matches[$n][3] = $liga_id.$home_team_id.$visitor_team_id;
		 	$matches[$n][4]	= $home_team." - ".$visitor_team;
		 	$matches[$n][5] = $home_team;
		 	$matches[$n][6] = $home_team_id;
		 	$matches[$n][7] = $visitor_team;
		 	$matches[$n][8] = $visitor_team_id;
		 	$matches[$n][9] = $sifra;

		 	
		 }


	}
	

}

print strftime('%H:%M:%s',localtime),"\tupisujem meceve \n";

my $konekcija = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu kod upisa meceva.: $DBI::errstr\n";

for (my $w=0;$w<scalar @matches;$w++)
{
	
	my $query=$konekcija->do("insert into ulaz_new (starttime,liga_id,liga, utk_id, utakmica,dom_id, dom,gost_id, gost,source) values ('$matches[$w][2]','$matches[$w][0]','$matches[$w][1]','$matches[$w][3]','$matches[$w][4]','$matches[$w][6]','$matches[$w][5]','$matches[$w][8]','$matches[$w][7]',$source_id)");
	
}

$konekcija->disconnect;

print strftime('%H:%M:%s',localtime),"\tupisujem kvote \n";

my $conn = DBI->connect($dsn, $user,$pass, { RaiseError => 1, AutoCommit => 0 }) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $count = 0;
my $statement;
my $insert_statement = "insert into ulaz_odds (utk_id,subgame,odd_value,source) values (?,?,?,?)";

$statement= $conn->prepare($insert_statement);

for (my $r=0;$r<scalar @odds;$r++)
{
	if ( $odds[$r][3] > 0) 
	{
		
		$statement->execute($odds[$r][1],$odds[$r][2],$odds[$r][3],$source_id);
		$count++;

	}
}


$conn->commit();
$conn->disconnect();


print strftime('%H:%M:%s',localtime),"\tUpisujem kvote u tabelu src_odds \n";


$conn = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $curr_procedure = "call import_data()";

my $imp_statement = $conn ->prepare($curr_procedure);
$imp_statement ->execute();

$imp_statement->finish();

$conn->disconnect();


print strftime('%H:%M:%s',localtime),"\tUpisujem nove kvote u tabelu src_current_odds \n";

$conn = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $curr_procedure = "call src_current_odds()";

my $imp_statement = $conn ->prepare($curr_procedure);
$imp_statement ->execute();

$imp_statement->finish();

$conn->disconnect();

print strftime('%H:%M:%s',localtime),"\tPovezujem meceve na osnovu veza timova. \n";

$conn = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

$curr_procedure = "call conn_matches_on_teams()";

$imp_statement = $conn ->prepare($curr_procedure);
$imp_statement ->execute();

$imp_statement->finish();

$conn->disconnect();


print strftime('%H:%M:%s',localtime),"\tupisujem gotov sam \n";
