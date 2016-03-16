#!/usr/bin/perl -w
use strict;
use LWP::Simple;
use DBI;
use DBD::mysql;
use DateTime;
use POSIX qw(strftime);

print strftime('%H:%M:%s',localtime),"\t Pocinjem skidanje kvota BalkanBet kladionice, Nek nam je sa srecom :) \n";

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

my $source_id = 3;
my @odds;
my @matches;
my @data=();
my @tmp=();
my @subgame=();
my @odds_values=();
my $j=0;

print strftime('%H:%M:%s',localtime),"\t Skidam ponudu po danima\n";

for (my $i=0;$i<7;$i++){

	my $now = DateTime->now( time_zone => 'local' );
	my $date = DateTime->now( time_zone => 'local' )->add( days => $i );

	
	my $date_format=$date->strftime("%Y-%m-%d");
	print $date_format,"\n";


	my $url = 'http://balkanbet.co.rs/site/content/kvote_ajax.php?kveri=datum&datum='.$date_format.'&sport=&liga=&mix=';
	


	my $data_for_day = get ($url) ;
	if (head($url)) {
	while ($data_for_day=~m{<td class="nbr" style="text-align: left;padding-left:10px;">Fudbal</td>\s+<td class="nbr">(.+?)</td>\s+<td class="nbr">(.+?)</td>\s+<td.+?>(.+?)</td>(.+?)</table>\s+</td>\s+</tr>}gs)

	{

		my $liga=$1;
		my $match_code=$2;
		my $match=$3;
		my $match_data=$4;
		

		$match=~s/'//g;
		$match=~m{(.+?)\s+-\s+(.+)}s;
		my $home_team = $1;
		my $visitor_team = $2;
		
		my $liga_id = $liga;	$liga_id=~s/\s+/_/g;
		my $home_team_id = $home_team; $home_team_id=~s/\s+/_/g;
		my $visitor_team_id = $visitor_team;$visitor_team_id=~s/\s+/_/g;
		
		
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

		while($match_data=~m{<table class="table-nested(.+?)</tbody>}gs)
		{
			my $odd_part=$1;
			while($odd_part=~m{<thead>(.+?)</thead>\s+<tbody>\s+<tr(.+?)</tr>\s+<tr(.+?)</tr>}gs)
			{
				my $games=$1;
				my $subgames = $2;
				my $odds = $3;
				
				my $beg=0;
				my $end = 0;
				@subgame=();
				@odds_values=();
				
				while ($subgames=~m{<td.+?>(.+?)</td>}gs)
				{
					my $sg = $1;
					if ($sg eq ""){$sg="bla"};
					
					push @subgame, $sg;
				}
				
				while ($odds=~m{<td.+?>(.+?)</td>}gs)
				{
					my $odd = $1;
					if ($odd eq ""){$odd="0"};
					push @odds_values, $odd;
				}
				
				while ($games=~m{<th colspan="(.+?)">(.+?)</th>}gs)
				{
					my $game_dist=$1;
					my $game=$2;
					
					$game_dist=~s/".+//g;
					
					$end = $end + $game_dist;

					
					for (my $i=$beg;$i<$end;$i++)
					{	
						my $j = scalar @odds;
						
						$odds[$j][0]=$odds_values[$i];
						$odds[$j][1]=$liga_id.$home_team_id.$visitor_team_id;
						$odds[$j][2]=$game;
						$odds[$j][3]=$subgame[$i];
					}
					
					$beg=$end;
					
				}
			}
		}
	}

	} else {
  		print "Does not exist ".$url."\n";;
	}

}


print strftime('%H:%M:%s',localtime),"\tupisujem meceve \n";

$konekcija = DBI->connect($dsn, $user,$pass) or die "ne moze da se poveze na bazu kod upisa meceva.: $DBI::errstr\n";

for (my $w=0;$w<scalar @matches;$w++)
{

	my $query=$konekcija->do("insert into ulaz_new (starttime,liga_id,liga, utk_id, utakmica,dom_id, dom,gost_id, gost,source) values ('$matches[$w][2]','$matches[$w][0]','$matches[$w][1]','$matches[$w][3]','$matches[$w][4]','$matches[$w][6]','$matches[$w][5]','$matches[$w][8]','$matches[$w][7]',$source_id)");

}

$konekcija->disconnect;


print strftime('%H:%M:%s',localtime),"\tupisujem kvote u ulaznu tabelu \n";

my $conn = DBI->connect($dsn, $user,$pass, { RaiseError => 1, AutoCommit => 0 }) or die "ne moze da se poveze na bazu: $DBI::errstr\n";

my $count = 0;
my $statement;
my $insert_statement = "insert into ulaz_odds (utk_id,game,subgame,odd_value,source) values (?,?,?,?,?)";

$statement= $conn->prepare($insert_statement);

for (my $r=0;$r<scalar @odds;$r++)
{
		
		$statement->execute($odds[$r][1],$odds[$r][2],$odds[$r][3],$odds[$r][0],$source_id);
		$count++;
		
		if($count>9999) {
			$conn->commit();
			$count = 0
		}
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

$curr_procedure = "call src_current_odds()";

$imp_statement = $conn ->prepare($curr_procedure);
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


print strftime('%H:%M:%s',localtime),"\tIzvrsio sam celu skriptu aj ce se vidimo. \n";


