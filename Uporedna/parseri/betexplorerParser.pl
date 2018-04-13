use strict;
use LWP::Simple;
use DBI;
use DBD::mysql;
use POSIX qw(strftime);


$url = '192.168.186.21/New_report/Uporedna/parseri/tmp.txt';
my $data = get($url);

print $data ;