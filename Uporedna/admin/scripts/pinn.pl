use strict;
use LWP::Simple;
use DBI;
use DBD::mysql;
use POSIX qw(strftime);

print strftime('%H:%M:%s',localtime),"\t Pocinjem skidanje kvota Pinnbet kladionice, Nek nam je sa srecom :) \n";


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

my $source_id = 4;
my $i=0;
my @matches=();
my @odds=();

my $day;
my $time;
my $date;

my $home_team_id;
my $visitor_team_id;
my $liga_id;
my $sifra_id;

print strftime('%H:%M:%s',localtime),"\t Skidam ponudu :\n";

my $sport = get ('http://www.pinnbet.com/ActualRatios1.aspx?kljucevi=&ListeId=429&IgraId=1&Danas=0&KladId=1') or die 'umre';
while ($sport=~m{<td class='lblNaslov'>(.+?)</td>(.+?)</a></td></tr></table><br></td></tr></table>}gs)
{
	my $liga = $1; 
	$liga_id = $liga; 
	
	print $liga,"\n";
	my $matches = $2;
	while ($matches=~m{<span id='domacin' style="display:none;">(.+?)</span><a class='ligatoplink' href='(.+?)'.+?<span id='gost' style="display:none;">(.+?)</span>}gs)
	{
		my $home_team	= $1;
		my $visitor_team	= $3;
		my $link 		= $2;
		
		
		$home_team=~s/'//g;
		$visitor_team=~s/'//g;
		
		$liga_id=~s/\s+/_/g;$liga_id=~s/-//g;
		$home_team_id = $home_team; $home_team_id=~s/\s+/_/g;
		$visitor_team_id = $visitor_team;$visitor_team_id=~s/\s+/_/g;

		
		my $match = get ('http://www.pinnbet.com/'.$link) or die 'umre';
		while ($match=~m{onclick="linkAddBet\('(.+?)\|.+?\|.+?\|.+?\|(.+?)\|(.+?)\|(.+?)\|.+?fudbal}gs)
		{
			
			my $code = $1;
			my $game = $2;
			my $subgame = $3;
			my $oddvalue = $4;
			

			
			my $i = scalar @odds;
			$odds[$i][0]=$oddvalue;
			$odds[$i][1]=$liga_id.$home_team_id.$visitor_team_id;
			$odds[$i][2]=$game;
			$odds[$i][3]=$subgame;

			
#			print $liga,"\t",$liga_id.$home_team_id.$visitor_team_id,"\t",$code,"\t",$game,"\t",$subgame,"\t",$oddvalue,"\n";
		}
		while ($match=~m{<span style="float:right">(.+?)&nbsp;&nbsp;(.+?)</span>}gs)
		{
			$day = $1;
			$time = $2;
			
			my $date=$day. " ". $time;
			
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

			
		}
	}
}


print strftime('%H:%M:%s',localtime),"\tupisujem meceve \n";

my $konekcija = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu kod upisa meceva.: $DBI::errstr\n";

for (my $w=0;$w<scalar @matches;$w++)
{
#	print $matches[$w][0],"\t",$matches[$w][1],"\t",$matches[$w][4],"\t",$matches[$w][2],"\t",$matches[$w][3],"\n";
	
	

	
	my $query=$konekcija->do("insert into ulaz_new (starttime,liga_id,liga, utk_id, utakmica,dom_id, dom,gost_id, gost,source) values ('$matches[$w][2]','$matches[$w][0]','$matches[$w][1]','$matches[$w][3]','$matches[$w][4]','$matches[$w][6]','$matches[$w][5]','$matches[$w][8]','$matches[$w][7]',$source_id)");
	

}

$konekcija->disconnect;


print strftime('%H:%M:%s',localtime),"\tupisujem kvote \n";

my $conn = DBI->connect($dsn, $user,$pass, { RaiseError => 1, AutoCommit => 0 }) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $count = 0;
my $statement;
my $insert_statement = "insert into ulaz_odds (utk_id,game,subgame,odd_value,source) values (?,?,?,?,?)";

$statement= $conn->prepare($insert_statement);

for (my $r=0;$r<scalar @odds;$r++)
{
#	if ( $odds[$r][0] > 0) 
#	{
		
		$statement->execute($odds[$r][1],$odds[$r][2],$odds[$r][3],$odds[$r][0],$source_id);
		$count++;
		
		if($count>1999) {
			$conn->commit();
			$count = 0
		}
#	}
}


$conn->commit();
$conn->disconnect();

print strftime('%H:%M:%s',localtime),"\tUpisujem kvote u tabelu src_odds \n";


$conn = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $curr_procedure = "call import_data_game()";

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

print strftime('%H:%M:%s',localtime),"\t Ok zavrsio sam, pozdrav\n";

 	