<?php 
	$sql="select a.vreme, 
		a.sifra, 
		a.takm, 
		a.ligaid, 
		a.dom, 
		a.gost, 
		a.ki11, 
		a.ki21, 
		a.ki31,
		a.ug11, 
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
		case when a.ki11 <= a.ki31 then 1 else 3 end fav,
		'Mozzart' as klad1,
		'Stenlybet' as klad2,
		'Superbet' as klad3,
		'Pyblicbet' as klad4,
		'Germanija' as klad5,
		'Supersport' as klad6
	from
	(
	select u.vreme vreme, u.sifra sifra, l.ime_lepo takm, d.ime_lepo dom, g.ime_lepo gost, m.ki_1 ki11, m.ki_x ki21, m.ki_2 ki31, m.ug3p ug11, u.id, u.liga_id ligaid
	from utakmica u, tim d, tim g, liga l , mozzart3 m
	where u.kolo = (select max(kolo) from utakmica)
	and u.liga_id=l.id
	and u.domacin_id=d.id
	and u.gost_id=g.id
	and m.utakmica_id=u.id
	and u.vreme > sysdate()
	 ) a
	left join stenlybetro3 st on st.utakmica_id=a.id
	left join superbetro3 su on su.utakmica_id=a.id
	left join publicbetro3 p on p.utakmica_id=a.id
	left join germanija1 g on g.utakmica_id=a.id
	left join Supersport1 s1 on s1.utakmica_id=a.id
	order by a.takm, a.sifra";
	$numBookmakers=6;
?>