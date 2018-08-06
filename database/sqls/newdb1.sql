insert into news (content) value ('{"phone":"123456***456","client":"001","paytype":"支付宝","money":"100","paytime":"12:06:12","foods":[{"name":"锦鲤抄","number":"2","price":"21"},{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"}]}');
insert into news (content) value ('{"phone":"41345***456","client":"002","paytype":"微信","money":"42.5","paytime":"12:07:35","foods":[{"name":"鹿语","number":"2","price":"71"},{"name":"冰饭","number":"2","price":"18"},{"name":"大龙","number":"48","price":"34"}]}');
truncate table news;
select * from news;



drop table orders;
select * from orders;
insert into orders (client,paytime,paytype,phone,foods) values ("001","1533441120","支付宝","12345678910",'[{"name":"锦鲤抄","number":"2","price":"21"},{"name":"炒饭","number":"3","price":"14"},{"name":"果冻","number":"48","price":"34"}]');



select * from foods;