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

/* pages */

insert into pages values(null, 1, '2009-04-02 11:30', 'page2', '
This copy of the libpng notices is provided for your convenience.  In case of
any discrepancy between this copy and the notices in the file png.h that is
included in the libpng distribution, the latter shall prevail.
<br><br>
COPYRIGHT NOTICE, DISCLAIMER, and LICENSE:
<br><br>
If you modify libpng you may insert additional notices immediately following
this sentence.
<br><br>
libpng versions 1.2.6, August 15, 2004, through 1.2.36, May 7, 2009, are
Copyright (c) 2004, 2006-2009 Glenn Randers-Pehrson, and are
distributed according to the same disclaimer and license as libpng-1.2.5
with the following individual added to the list of Contributing Authors
<br><br>
libpng versions 0.97, January 1998, through 1.0.6, March 20, 2000, are
Copyright (c) 1998, 1999 Glenn Randers-Pehrson, and are
distributed according to the same disclaimer and license as libpng-0.96,
with the following individuals added to the list of Contributing Authors:
', 0);

insert into pages values(null, 2, '2009-04-01 11:30', 'page3', '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec id massa vitae risus eleifend consectetuer. Donec accumsan ornare purus. Aliquam malesuada. Integer rutrum, justo id fringilla congue, ligula libero mattis odio, quis pulvinar tellus sapien non enim. Quisque in urna eu lorem pharetra feugiat. Quisque ligula lacus, congue tristique, consequat in, aliquet nec, augue. Ut lobortis. Donec a leo. Duis ipsum. In porta felis sed nisl. Pellentesque ipsum. Maecenas ac dui. Etiam accumsan condimentum pede. Cras sit amet nunc scelerisque nunc aliquam porttitor. Fusce hendrerit laoreet sem. Aenean mi ante, faucibus sed, fringilla eu, malesuada eu, libero. Curabitur dictum sem. Nullam dignissim euismod nibh. Suspendisse eu diam.
<br><br>
Fusce eget nisl imperdiet lectus sagittis tempor. Aenean condimentum elementum nisi. Integer sollicitudin. Suspendisse non leo. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis aliquam, tellus nec hendrerit mattis, felis lectus euismod eros, eu auctor pede magna eget odio. Morbi elementum lectus non eros. Morbi volutpat viverra diam. Fusce sed elit eu nisi egestas eleifend. Pellentesque pellentesque. Etiam sed mauris vitae nunc accumsan cursus. Fusce tristique lacinia quam. In hac habitasse platea dictumst.
', 0);

insert into pages values(null, 3, '2009-02-01 11:00', 'page4', '
Aliquam erat volutpat. Vestibulum sollicitudin turpis et eros. Sed euismod massa sit amet enim. Nulla nec tortor non nisl tristique sodales. Nam scelerisque feugiat mi. Nunc ac risus. Duis egestas arcu in justo. Vestibulum ut turpis vitae sem rutrum pharetra. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam ligula augue, molestie ut, ullamcorper ut, tristique ut, nibh.
<br><br>
Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Integer hendrerit dignissim nunc. Nam viverra, ligula eget fermentum congue, tortor arcu feugiat leo, in lobortis risus nunc eu mauris. Nunc elit justo, elementum mollis, tempor quis, pretium ut, purus. In hac habitasse platea dictumst. Donec fringilla, felis eget sodales facilisis, ligula quam egestas diam, id feugiat pede ipsum a elit. Duis non lorem. Cras sollicitudin. In hac habitasse platea dictumst. In hac habitasse platea dictumst. Integer diam ipsum, pretium et, commodo sed, suscipit nec, velit. Sed arcu. Mauris mollis elementum risus. Nunc at justo a ante sagittis pharetra. Proin eu mauris eget dui facilisis vestibulum. Donec ut diam quis libero fermentum vestibulum. Sed in purus. Mauris molestie urna nec dolor.
<br><br>
Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas dapibus ipsum vitae ligula. Aliquam ornare dignissim velit. Sed et lacus ut tortor dapibus tempus. Vestibulum consectetuer purus. Aliquam eleifend diam id leo. Sed mattis. Aenean eget lorem in velit rutrum porta. Cras rhoncus, arcu sed iaculis laoreet, tellus arcu interdum ipsum, vitae suscipit massa sem in dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Pellentesque volutpat vestibulum tellus. Quisque dolor justo, lacinia in, ultricies vitae, pretium quis, ligula. Morbi a neque et enim ultricies interdum. Integer laoreet, leo in consequat ornare, tellus magna volutpat lorem, suscipit vehicula eros eros vel pede. Donec vel metus ac arcu feugiat bibendum. Fusce tempor neque id tortor. Curabitur a eros non erat ultricies nonummy.
', 0);
