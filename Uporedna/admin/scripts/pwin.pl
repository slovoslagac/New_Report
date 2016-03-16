use strict;
use LWP::Simple;
use DBI;
use DBD::mysql;
use POSIX qw(strftime);

print strftime('%H:%M:%s',localtime),"\t Pocinjem skidanje kvota PlanetWin kladionice, Nek nam je sa srecom :) \n";


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

my $source_id = 5;
my @groups;
my @odds;
my @matches;
my $i;

my $dom;
my $gost;
my $ki1;
my $kix;
my $ki2;

print strftime('%H:%M:%s',localtime),"\tSkidam ponudu po ligama \n";

my $plwin=get('http://www.planetwin365.rs/Sport/Groups.aspx?TipoVis=1') or die 'ne ide';

while ($plwin=~m{<div class="divNSport" title="Fudbal">Fudbal</div>(.+?)<div class="divNSport"}gs)
{
	my $lige=$1;
	
	while ($lige=~m{<a title="(.+?)" href="OddsAsync.aspx\?EventID=(.+?)" id="lE">}gs)
	{
		my $sifra=$2;
		my $liga=$1;
		
		my $liga_id = $liga;	$liga_id=~s/\s+/_/g;

		print $liga, "\n";
		
		sleep 0.5;

#	sve	@groups = (101,694,24,703,700,7,8,251,22,23,21,424,695,697,501,706,707,863,698,718,500,722,950,696,723,31,506,509,514,27,28,479,25,26,113,114,38,686,693,58,688,690,75,942,125,1016,124,123,426,705,712,713,715);
		@groups = (101,694,24,703,700,7,8,251,22,23,21,424,695,697,501,706,707,863,698,718,500,722,950,696,723,31,506,509,514,27,28,479,25,26,113,114,38,686,693,58,688,690,75,942,125,1016,124,123,426);
#		@groups = (101);

		

		for (my $j=0 ; $j < 53; $j++) 
		{
			my $group =  $groups[$j];
			my $sve=get('http://www.planetwin365.rs/ControlsSkin/OddsEvent.aspx?ShowLinkFastBet=0&EventID='.$sifra.'&IDGruppoQuota='.$group) or die 'Ne hvata dobro ki';
			while ($sve=~m{data-sottoevento-id="(.+?)"\s+data-sottoevento-name=.+?OddsQuotaItemStyle(.+?)</table>}gs)
			{ 
				my $sifra=$1;
				my $kvote=$2;
				
				while($kvote=~m{data-tipoquota="(.+?)">.+?sCPqt,.+?\)\;\">(.+?)</a>}gs)
				{
					my $tip = $1;
					my $kvota=$2;
					
					$kvota =~ s/,/\./g;
					$tip =~s/&amp;//g;
					
					my $i = scalar @odds;
					
					$odds[$i][0]=$kvota;
					$odds[$i][1]=$sifra;
					$odds[$i][2]=$tip;



	
				}

			}
			
			if($group == 101) 
			{
				while($sve=~m{class="cqDateTbl">(.+?).\s+(.+?)\s+(.+?)</td>(.+?)(<table cellpadding="0" cellspacing="0"  width="100%">|</table>\s+</div>\s+</div>\s+</div>)}gs)
				{
					my $day = $1;
					my $month = $2;
					my $year = $3;
					my $mathes = $4;
					
					my $date = $year."-".$month."-".$day,"\n";
					while ($mathes=~m{data-sottoevento-id="(.+?)" data-sottoevento-name="(.+?)"\s+data-idtipoevento="1" >.+?<td class="dtInc">(.+?)</td>}gs)
					{
						my $code = $1;
						my $match = $2;
						my $time = $3;
						$match=~m{(.+?)\s+-\s+(.+)};
						my $home_team = $1;
						my $visitor_team = $2;
						
						
						my $home_team_id = $home_team; $home_team_id=~s/\s+/_/g;
						my $visitor_team_id = $visitor_team;$visitor_team_id=~s/\s+/_/g;
						
						my $date = $year."-".$month."-".$day." ".$time,"\n";
						
						
						my $n = scalar @matches;
						
						$matches[$n][0] = $liga_id;	 	
					 	$matches[$n][1] = $liga;
					 	$matches[$n][2] = $date;
					 	$matches[$n][3] = $code;
					 	$matches[$n][4]	= $home_team." - ".$visitor_team;
					 	$matches[$n][5] = $home_team;
					 	$matches[$n][6] = $home_team_id;
					 	$matches[$n][7] = $visitor_team;
					 	$matches[$n][8] = $visitor_team_id;
					}



				}
				
			}
			


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

print strftime('%H:%M:%s',localtime),"\tupisujem kvote u ulaznu tabelu \n";

my $conn = DBI->connect($dsn, $user,$pass, { RaiseError => 1, AutoCommit => 0 }) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $count = 0;
my $statement;
my $insert_statement = "insert into ulaz_odds (utk_id,subgame,odd_value,source) values (?,?,?,?)";

$statement= $conn->prepare($insert_statement);

for (my $r=0;$r<scalar @odds;$r++)
{
	if ( $odds[$r][0] > 0) 
	{
		
		$statement->execute($odds[$r][1],$odds[$r][2],$odds[$r][0],$source_id);
		$count++;
		
		if($count>999) {
			$conn->commit();
			$count = 0
		}
#	print IZLAZ$odds[$r][1],"\t",$odds[$r][2],"\t",$odds[$r][0],"\t",$source_id,"\n";
	
	}
	
}


$conn->commit();
$conn->disconnect();

print strftime('%H:%M:%s',localtime),"\tUpisujem kvote u tabelu src_odds \n";

#sleep 10;

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



			




