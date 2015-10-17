<?php
	$sql="select a.vreme, 
		a.sifra, 
		a.takm, 
		a.ligaid, 
		a.dom, 
		a.gost, 
		truncate(k.vrednost,2) as ki11, 
		truncate(k1.vrednost,2) as ki21, 
		truncate(k2.vrednost,2) as ki31,
		truncate(k3.vrednost,2) as ug11, 
		p.ki_1 as ki12, 
		p.ki_x as ki22, 
		p.ki_2 as ki32,
		p.ug3p as ug12,
		s.ki_1 as ki13, 
		s.ki_x as ki23, 
		s.ki_2 as ki33,
		s.ug3p as ug13,
		pi.ki_1 as ki14, 
		pi.ki_x as ki24, 
		pi.ki_2 as ki34,
		pi.ug3p as ug14,
		b.ki_1 as ki15, 
		b.ki_x as ki25, 
		b.ki_2 as ki35,
		b.ug3p as ug15,
		me.ki_1 as ki16, 
		me.ki_x as ki26, 
		me.ki_2 as ki36,
		me.ug3p as ug16,
		mb.ki_1 as ki17, 
		mb.ki_x as ki27, 
		mb.ki_2 as ki37,
		mb.ug3p as ug17,
		g.ki_1 as ki18, 
		g.ki_x as ki28, 
		g.ki_2 as ki38,
		g.ug3p as ug18,
		s1.ki_1 as ki19, 
		s1.ki_x as ki29, 
		s1.ki_2 as ki39,
		s1.ug3p as ug19,
		case when k.vrednost <= k2.vrednost then 1 else 3 end fav,
		'Mozzart' as klad1,
		'PlanetWin' as klad2,
		'Soccer' as klad3,
		'Pinnbet' as klad4,
		'Balkanbet' as klad5,
		'Meridian' as klad6,
		'Maxbet' as klad7,
		'Germanija' as klad8,
		'Supersport' as klad9
	from
	(
	select u.vreme vreme, u.sifra sifra, l.ime_lepo takm, d.ime_lepo dom, g.ime_lepo gost, u.id, u.liga_id ligaid, l.position pos
	from utakmica u, tim d, tim g, liga l 
	where u.kolo = (select max(kolo) from utakmica)
	and u.liga_id=l.id
	and u.domacin_id=d.id
	and u.gost_id=g.id
	 ) a
	left join kvota k on k.utakmica_id=a.id and k.podigra_id = 1
	left join kvota k1 on k1.utakmica_id=a.id and k1.podigra_id = 2
	left join kvota k2 on k2.utakmica_id=a.id and k2.podigra_id = 3
	left join kvota k3 on k3.utakmica_id=a.id and k3.podigra_id = 4
	left join planetwin3 p on p.utakmica_id=a.id
	left join maxbet3 mb on mb.utakmica_id=a.id
	left join soccer3 s on s.utakmica_id=a.id
	left join Pinbet pi on pi.utakmica_id=a.id
	left join balkanbet3 b on b.utakmica_id=a.id
	left join meridian3 me on me.utakmica_id=a.id
	left join germanija1 g on g.utakmica_id=a.id
	left join Supersport1 s1 on s1.utakmica_id=a.id
	order by a.pos desc, a.takm, a.sifra";
	$numBookmakers=9;
?>