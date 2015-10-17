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
		st.ki_1 as ki12, 
		st.ki_x as ki22, 
		st.ki_2 as ki32,
		st.ug3p as ug12,
		su.ki_1 as ki13, 
		su.ki_x as ki23, 
		su.ki_2 as ki33,
		su.ug3p as ug13,
		p.ki_1 as ki14, 
		p.ki_x as ki24, 
		p.ki_2 as ki34,
		p.ug3p as ug14,
		g.ki_1 as ki15, 
		g.ki_x as ki25, 
		g.ki_2 as ki35,
		g.ug3p as ug15,
		s1.ki_1 as ki16, 
		s1.ki_x as ki26, 
		s1.ki_2 as ki36,
		s1.ug3p as ug16,
		case when k.vrednost <= k2.vrednost then 1 else 3 end fav,
		'Mozzart' as klad1,
		'Stenlybet' as klad2,
		'Superbet' as klad3,
		'Publicbet' as klad4,
		'Germanija' as klad5,
		'Supersport' as klad6
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
	left join stenlybetro3 st on st.utakmica_id=a.id
	left join superbetro3 su on su.utakmica_id=a.id
	left join publicbetro3 p on p.utakmica_id=a.id
	left join germanija1 g on g.utakmica_id=a.id
	left join Supersport1 s1 on s1.utakmica_id=a.id
	order by a.pos desc, a.takm, a.sifra";
	$numBookmakers=6;
?>