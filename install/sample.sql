/* users */

update users set first_name='Radu', fam_name='Potop', email='wooptoo@gmail.com',
	pass='1e41c981637834caec149b4d33f7f8566076ddfa', about='this is me'
	where id_user=1;

insert into users values(null, 2, 'Ion', 'Popescu', 'popescu@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');

insert into users values(null, 3, 'Gavril', 'Adace', 'adace@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');
insert into users values(null, 3, 'Bartha', 'Ciprian', 'bartha@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', '');
insert into users values(null, 3, 'Adam', 'Gergely', 'gergely@yahoo.com',
	'83592796bc17705662dc9a750c8b6d0a4fd93396', 'Admiral Anquietas');


/* topics */

insert into topics values(null, 1, '2009-02-13 02:20', 'Hello Dolly');
insert into topics values(null, 5, '2009-02-14 08:30', 'This is Louis, Dolly');
insert into topics values(null, 4, '2009-02-15 14:15', 'Lorem Ipsum');
insert into topics values(null, 1, '2009-05-13 03:12', 'Despre JavaScript');


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
insert into posts values(null, 4, 1, '2009-05-13 02:00', '
JavaScript este un limbaj de programare orientat obiect bazat pe conceptul prototipurilor. Este folosit mai ales pentru introducerea unor funcţionalităţi în paginile web, codul Javascript din aceste pagini fiind rulat de către browser.
');
insert into posts values(null, 4, 3, '2009-05-13 03:00', '
În ciuda numelui şi a unor similarităţi în sintaxă, între JavaScript şi limbajul Java nu există nicio legătură. Ca şi Java, JavaScript are o sintaxă apropiată de cea a limbajului C, dar are mai multe în comun cu limbajul Self decât cu Java.
');

/* pages */

update pages set body='
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec id massa vitae risus eleifend consectetuer. Donec accumsan ornare purus. Aliquam malesuada. Integer rutrum, justo id fringilla congue, ligula libero mattis odio, quis pulvinar tellus sapien non enim. Quisque in urna eu lorem pharetra feugiat. Quisque ligula lacus, congue tristique, consequat in, aliquet nec, augue. Ut lobortis. Donec a leo. Duis ipsum. In porta felis sed nisl. Pellentesque ipsum. Maecenas ac dui. Etiam accumsan condimentum pede. Cras sit amet nunc scelerisque nunc aliquam porttitor. Fusce hendrerit laoreet sem. Aenean mi ante, faucibus sed, fringilla eu, malesuada eu, libero. Curabitur dictum sem. Nullam dignissim euismod nibh. Suspendisse eu diam.
<br><br>
<strong>
Fusce eget nisl imperdiet lectus sagittis tempor. Aenean condimentum elementum nisi. Integer sollicitudin. Suspendisse non leo. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis aliquam, tellus nec hendrerit mattis, felis lectus euismod eros, eu auctor pede magna eget odio. Morbi elementum lectus non eros. Morbi volutpat viverra diam. Fusce sed elit eu nisi egestas eleifend. Pellentesque pellentesque. Etiam sed mauris vitae nunc accumsan cursus. Fusce tristique lacinia quam. In hac habitasse platea dictumst.
</strong>
<br><br>
<em>
Aliquam erat volutpat. Vestibulum sollicitudin turpis et eros. Sed euismod massa sit amet enim. Nulla nec tortor non nisl tristique sodales. Nam scelerisque feugiat mi. Nunc ac risus. Duis egestas arcu in justo. Vestibulum ut turpis vitae sem rutrum pharetra. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam ligula augue, molestie ut, ullamcorper ut, tristique ut, nibh.
</em>
<br><br>
' where id_page=1;

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
');

insert into pages values(null, 2, '2009-04-01 11:30', 'page3', '
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec id massa vitae risus eleifend consectetuer. Donec accumsan ornare purus. Aliquam malesuada. Integer rutrum, justo id fringilla congue, ligula libero mattis odio, quis pulvinar tellus sapien non enim. Quisque in urna eu lorem pharetra feugiat. Quisque ligula lacus, congue tristique, consequat in, aliquet nec, augue. Ut lobortis. Donec a leo. Duis ipsum. In porta felis sed nisl. Pellentesque ipsum. Maecenas ac dui. Etiam accumsan condimentum pede. Cras sit amet nunc scelerisque nunc aliquam porttitor. Fusce hendrerit laoreet sem. Aenean mi ante, faucibus sed, fringilla eu, malesuada eu, libero. Curabitur dictum sem. Nullam dignissim euismod nibh. Suspendisse eu diam.
<br><br>
Fusce eget nisl imperdiet lectus sagittis tempor. Aenean condimentum elementum nisi. Integer sollicitudin. Suspendisse non leo. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis aliquam, tellus nec hendrerit mattis, felis lectus euismod eros, eu auctor pede magna eget odio. Morbi elementum lectus non eros. Morbi volutpat viverra diam. Fusce sed elit eu nisi egestas eleifend. Pellentesque pellentesque. Etiam sed mauris vitae nunc accumsan cursus. Fusce tristique lacinia quam. In hac habitasse platea dictumst.
');

insert into pages values(null, 3, '2009-02-01 11:00', 'page4', '
Aliquam erat volutpat. Vestibulum sollicitudin turpis et eros. Sed euismod massa sit amet enim. Nulla nec tortor non nisl tristique sodales. Nam scelerisque feugiat mi. Nunc ac risus. Duis egestas arcu in justo. Vestibulum ut turpis vitae sem rutrum pharetra. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam ligula augue, molestie ut, ullamcorper ut, tristique ut, nibh.
<br><br>
Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Integer hendrerit dignissim nunc. Nam viverra, ligula eget fermentum congue, tortor arcu feugiat leo, in lobortis risus nunc eu mauris. Nunc elit justo, elementum mollis, tempor quis, pretium ut, purus. In hac habitasse platea dictumst. Donec fringilla, felis eget sodales facilisis, ligula quam egestas diam, id feugiat pede ipsum a elit. Duis non lorem. Cras sollicitudin. In hac habitasse platea dictumst. In hac habitasse platea dictumst. Integer diam ipsum, pretium et, commodo sed, suscipit nec, velit. Sed arcu. Mauris mollis elementum risus. Nunc at justo a ante sagittis pharetra. Proin eu mauris eget dui facilisis vestibulum. Donec ut diam quis libero fermentum vestibulum. Sed in purus. Mauris molestie urna nec dolor.
<br><br>
Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Maecenas dapibus ipsum vitae ligula. Aliquam ornare dignissim velit. Sed et lacus ut tortor dapibus tempus. Vestibulum consectetuer purus. Aliquam eleifend diam id leo. Sed mattis. Aenean eget lorem in velit rutrum porta. Cras rhoncus, arcu sed iaculis laoreet, tellus arcu interdum ipsum, vitae suscipit massa sem in dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Pellentesque volutpat vestibulum tellus. Quisque dolor justo, lacinia in, ultricies vitae, pretium quis, ligula. Morbi a neque et enim ultricies interdum. Integer laoreet, leo in consequat ornare, tellus magna volutpat lorem, suscipit vehicula eros eros vel pede. Donec vel metus ac arcu feugiat bibendum. Fusce tempor neque id tortor. Curabitur a eros non erat ultricies nonummy.
');

insert into pages values(null, 1, '2009-05-13 11:00', 'Video encoder', '
Cateva detalii despre cum se poate face video encoderul pentru proiectul cu Streaming Media Website.<br>
<h3>Idei</h3>
<ul>
	<li>se poate face in CGI</li>
	<li>pot sa-l scriu in bash</li>
	<li>putem folosit fie mencoder sau ffmpeg</li>
	<li>scriptul CGI se poate interfata cu php</li>
	<li>parerea mea e ca nu avem nevoie de server de streaming<br>
		(scriptul produce fisierul .flv care e streamed direct de un player flash)</li>
	<li>si ffmpeg si mencoder pot converti din (aproape) orice format in .flv<br>
		(nu trebuie specificat => less fuss)</li>
</ul>
<h3>Functionare</h3>
<ul>
	<li>php-ul uploadeaza undeva fisierul video</li>
	<li>ii paseaza scriptului cgi path-ul unde gaseste video-ul (php exec, etc.)</li>
	<li>scriptul produce un video pe care il poate copia/muta undeva accesibil de catre php</li>
	<li>php paseaza playerului flash path-ul catre .flv </li>
</ul>
<h3>Note</h3>
<ul>
	<li>Se mai poate implementa un queue pentru encoding, in caz ca sunt introduse mai multe filme de-o data pentru encoding.</li>
	<li>php-ul ar trebui sa genereze niste linkuri unice (permalinks) catre diversele videos uploadate<br>
		(hash-uri a la youtube merge, desi sunt cam idioate)</li>
	<li>trebuie rezolvata problema cu stocarea mai multor videos in acelasi loc<br>
		(putem sa le facem rename de la numele original, la un hash sau. e tricky) </li>
</ul>
<h3>Exemple</h3>
<h4>CGI</h4>
<pre>
#!/bin/sh

#varianta ffmpeg:
ffmpeg -i $1 -ar 22050 $1.flv

#varianta mencoder (nu am testat-o inca):
mencoder -forceidx -of lavf -oac mp3lame -lameopts abr:br=56 \
-srate 22050 -ovc lavc -lavcopts \
vcodec=flv:vbitrate=250:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 \
-vf scale=360:240 -o $1.flv $1
</pre>

<h4>PHP</h4>
Sau direct in php
<pre>

system("fmpeg -i $1 -ar 22050 $1.flv", $return)
if ($return == 0) echo DONE

</pre>
Wooptoo 17:32, 19 March 2009 (EET)
');

/* calendars */

insert into calendars values(null, 1, '2009-04-29 13:00', '2009-04-29 15:00',
	'Cercetari operationale');
insert into calendars values(null, 3, '2009-04-30 08:00', '2009-05-01 08:00',
	'Limbaje formale');
insert into calendars values(null, 5, '2009-05-12 16:00', '2009-05-13 16:00',
	'Statistica');
insert into calendars values(null, 4, '2009-05-14 16:00', '2009-05-16 16:00',
	'Sesiunea de comunicari');
