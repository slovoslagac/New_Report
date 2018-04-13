select * from publicbetro1
;
select * from publicbetro2
;
select * from publicbetro3
;
truncate publicbetro3
;
insert into publicbetro3 (liga, domacin,gost, ki_1, ki_x, ki_2)
select p.liga, p.domacin, p.gost, p1.kvota, p2.kvota, p3.kvota 
from publicbetro2 p, publicbetro1 p1, publicbetro1 p2, publicbetro1 p3
where p.sifra = p1.sifra
and p.sifra = p2.sifra
and p.sifra = p3.sifra
and p1.podigra = '1'
and p2.podigra = 'X'
and p3.podigra = '2'
;
call spajanje_publicbetro()
;