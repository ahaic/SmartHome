var page = 1, toall = 0, app, p_start, p_end, p_pre, p_next, p_now;
var table_id = 2, row = 5, cid = 0, etype = 0, nid = 0;

function changePage(n){
	if(n == 0){
		page = 1;	
	}else if(n == 1){
		page = toall;	
	}else if(n == 2){
		if(page <= 1){
			page == 1;	
		}else{
			page -= 1;	
		}	
	}else if(n == 3){
		if(page >= toall){
			page == toall;	
		}else{
			page += 1;	
		}	
	}
	getData();	
}

function getData(){
	html = $.ajax({		
		url : 'index.php?q=home/app/'+ table_id +'/'+ row +'/'+ cid +'/'+ etype +'/'+ nid +'.html&p='+ page +'&rand='+Math.random(),
		async: false,
		dataType: 'json',
		cache : false,
	}).responseText; 
	data = eval ("(" + html + ")");
	toall = data.toall;
	app = data.data;
	fillHtml();
	p_start = '<a href="javascript:void(0);" onclick="changePage(0)">首页</a>';
	p_end = '<a href="javascript:void(0);" onclick="changePage(1)">尾页</a>';
	p_pre = '<a href="javascript:void(0);" onclick="changePage(2)">上一页</a>';
	p_next = '<a href="javascript:void(0);" onclick="changePage(3)">下一页</a>';
	p_now = '第'+ page +'页';
	$('#p_start').html(p_start);
	$('#p_pre').html(p_pre);	
	$('#p_next').html(p_next);
	$('#p_end').html(p_end);
	$('#p_now').html(p_now);
	$('#p_toall').html(toall);
}