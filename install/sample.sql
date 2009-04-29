/* users */

update users set first_name='Radu', fam_name='Potop', email='wooptoo@gmail.com',
	pass='1e41c981637834caec149b4d33f7f8566076ddfa', about='this is me'
	where id_user=1;

insert into users values(null, 2, 'Dumitru', 'Radoiu', 'radoiu@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');

insert into users values(null, 3, 'Gavril', 'Adace', 'adace@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');
insert into users values(null, 3, 'Bartha', 'Ciprian', 'bartha@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');
insert into users values(null, 3, 'Adam', 'Gergely', 'gergely@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');


/* topics */

insert into topics values(null, 1, '2009-02-13 02:20', 'Hello Dolly');
insert into topics values(null, 5, '2009-02-14 08:30', 'This is Louis');
insert into topics values(null, 4, '2009-02-15 14:15', 'Dolly');


/* posts */

insert into posts values(null, 1, 1, '2009-02-13 02:20',
	'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec id massa vitae risus eleifend consectetuer. Donec accumsan ornare purus. Aliquam malesuada. Integer rutrum, justo id fringilla congue, ligula libero mattis odio, quis pulvinar tellus sapien non enim.');
insert into posts values(null, 1, 3, '2009-02-14 02:00',
	'Ut lobortis. Donec a leo. Duis ipsum. In porta felis sed nisl. Pellentesque ipsum. Maecenas ac dui. Etiam accumsan condimentum pede.');
insert into posts values(null, 1, 5, '2009-04-15 02:20',
	'Cras sit amet nunc scelerisque nunc aliquam porttitor. Fusce hendrerit laoreet sem. Aenean mi ante, faucibus sed, fringilla eu, malesuada eu, libero. Curabitur dictum sem. Nullam dignissim euismod nibh. Suspendisse eu diam.');
insert into posts values(null, 2, 1, '2009-02-13 02:20',
	'Fusce eget nisl imperdiet lectus sagittis tempor. Aenean condimentum elementum nisi. Integer sollicitudin. Suspendisse non leo. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis aliquam, tellus nec hendrerit mattis, felis lectus euismod eros, eu auctor pede magna eget odio.');
insert into posts values(null, 2, 4, '2009-02-14 02:20',
	'Morbi elementum lectus non eros. Morbi volutpat viverra diam. Fusce sed elit eu nisi egestas eleifend. Pellentesque pellentesque. Etiam sed mauris vitae nunc accumsan cursus. Fusce tristique lacinia quam. In hac habitasse platea dictumst.');
insert into posts values(null, 2, 3, '2009-03-13 02:20',
	'Aliquam erat volutpat. Vestibulum sollicitudin turpis et eros. Sed euismod massa sit amet enim. Nulla nec tortor non nisl tristique sodales. ');
insert into posts values(null, 3, 1, '2009-02-16 02:20',
	'Nam scelerisque feugiat mi. Nunc ac risus. Duis egestas arcu in justo. Vestibulum ut turpis vitae sem rutrum pharetra. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam ligula augue, molestie ut, ullamcorper ut, tristique ut, nibh.');
insert into posts values(null, 3, 2, '2009-03-13 02:20',
	'Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Integer hendrerit dignissim nunc. Nam viverra, ligula eget fermentum congue, tortor arcu feugiat leo, in lobortis risus nunc eu mauris.');
