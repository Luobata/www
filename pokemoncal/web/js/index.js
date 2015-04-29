var attack_id=0;
var defense_id=0;
var attack_nature=1;
var defense_nature=1;
//初始化chosen框
window.onload=function(){
	$(':radio').radiocheck();
	$(':checkbox').radiocheck();
	$('.chosen-select').chosen();
	$('.pm-select').on('change', function(evt, params) {
   	 var info=params.selected;
   	 var a=info.split(",");
   	 var id=a[0];
   	 var type=a[1];
   	 var con=$(this).parentsUntil(".con")[3];
   	 var infocol=con.nextElementSibling;
   	 var bo=con.parentElement;
   	 //可以用隐藏input框来表示id，哪种更好？其次，如何在其他function中直接获取select的value？？同理nature
   	 if($(bo).hasClass('c-left')){
   	 	attack_id=id;
   	 }else{
   	 	defense_id=id;
   	 }
   	 $.ajax({
   	 	url: './index.php?r=cal/poke&pmid='+id+'&type='+type,
   	 	type: 'GET',
   	 	dataType: 'json',
   	 	data: {},
   	 	success:function(data){
   	 		var hp=$(infocol).find('.hp .base');
   	 			wg=$(infocol).find('.at .base');
   	 			wf=$(infocol).find('.df .base');
   	 			tg=$(infocol).find('.sa .base');
   	 			tf=$(infocol).find('.sd .base');
   	 			sd=$(infocol).find('.sp .base');
   	 			pmid=$(bo).find('.id');
   	 			img=$(bo).find("img");
   	 			pktype=$(bo).find('.type');
   	 			pktype1=$(bo).find('.type1');
   	 			pktype2=$(bo).find('.type2');
   	 			src=(type==0?'img/pm/'+id+'.png':'img/pm/'+id+'-'+type+'.png');
   	 		//改变6维种族与图片
   	 		hp.prop('value', data.hp);
   	 		wg.prop('value', data.wg);
   	 		wf.prop('value', data.wf);
   	 		tg.prop('value', data.tg);
   	 		tf.prop('value', data.tf);
   	 		sd.prop('value', data.sd);
   	 		pmid.prop('value', id);
   	 		img.attr('src', src);
   	 		pktype.html(data.type1_zh+' '+data.type2_zh);
   	 		pktype1.prop('value', data.type1);
   	 		pktype2.prop('value', data.type2);
   	 		//根据对象改变
   	 		CalAll(bo);

   	 	}
   	 });
  	});
	$('.nature-select').on('change',function(evt, params) {
   	 var info=params.selected;
   	     con=$(this).parentsUntil('.con');
		 con=$(con)[con.length-1].parentElement;
   	$(con).find('.nature').prop('value', info);
   	CalAll(con);
  	});
  	$('.type-select').on('change',function(evt,params) {
  		 var info=params.selected;
   	     con=$(this).parentsUntil('.con');
		 con=$(con)[con.length-1].parentElement;
   	$(con).find('.skill-type').prop('value', info);
   	CalAtt(1);
	CalAtt(2);
  	});
	//手动改变数值绑定事件
	$('.level,.at,.df,.sa,.sp,.sd,.hp,.a-skill,.a-item,.a-ability').bind('input', function(event){
		//获取对象
		var con=$(this).parentsUntil('.con');
			con=$(con)[con.length-1].parentElement;
		CalAll(con);
	});
	$('.cd,.col-xs-3').bind('change', function(event) {
		CalAtt(1);
		CalAtt(2);
	});
	//改变攻击类型
	$('.kind').on('change.radiocheck', function() {
		var a=$(this).parents('.col-xs-3');
		var b=$(this).parents('.col-xs-3').find('.att-kind');
		$(this).parents('.col-xs-3').find('.att-kind').prop('value', $(this).val());
	// Do something
	});
	$('.clouds').on('change.radiocheck', function() {
		$('.att-cloud').prop('value', $(this).val());
	// Do something
	});
	$('.c-left-dd,.c-right-dd').on('change.radiocheck', function() {
		$(this).parents('.col-xs-3').find('input[type=hidden]').prop('value', $(this).val());
	// Do something
	});
	CalAtt(1);
	CalAtt(2);
}


$('.level').bind("oninput",function(){
	
})
//等级输入校验
function maxlevel(event){
	var level=event.target;
	var val=level.value;
	if(isNaN(val)||val>100){
	event.target.value=100;
	}else if(val==""||val==null){
		//event.target.value=100;
	}
}
//根据能力值计算hp接口
function getHpVal(level,base,ivs,evs,id){
	//判断id是否为脱壳忍者，脱壳忍者的pmid为292
	var hp=(id==292?1:parseInt((parseInt(base)*2+parseInt(ivs)+parseInt(evs)/4)*level/100+10+parseInt(level)));
	return hp;
}
function getVal(level,base,ivs,evs,nature){
	level=parseInt(level);
	base=parseInt(base);
	ivs=parseInt(ivs);
	evs=parseInt(evs);
	//nature=parseInt(nature);
	var val=parseInt(((base*2+ivs+evs/4)*level/100+5)*nature);
	return val;
}
//改变hp显示数值公共接口
function CalHp(event){
	var bo;
	var a_level=$(event).find('.level').val();
		a_hp_base=$(event).find('.hp .base').val();
		a_hp_ivs=$(event).find('.hp .ivs').val();
		a_hp_evs=$(event).find('.hp .evs').val();
		id=$(event).find('.id').val();
		con=$(this).parentsUntil('.con');
		//a_hp=$($(con)[con.length-1].parentElement).find('.hp .total');
		a_hp=$(event).find('.hp .total');
	var hp=getHpVal(a_level,a_hp_base,a_hp_ivs,a_hp_evs,id);
		a_hp.html(hp);
}
//改变能力值显示数值公共接口
function CalVal(event,tar){
	tar='.'+tar;
	var level = $(event).find('.level').val();
		base = $(event).find(tar+' .base').val();
		ivs = $(event).find(tar+' .ivs').val();
		evs = $(event).find(tar+' .evs').val();
		con = $(event).find(tar+' .total');
		nature = $(event).find('.nature').val();
		na=1;
		upstairs=$(event).find(tar+' .boost').val();
		upstairs=parseInt(upstairs);
		if(upstairs>=0){
			upstairs=(2+upstairs)/2;
		}else{
			upstairs=2/(2-upstairs);
		}
	if(nature!=1){
		nature=nature.split(",");
		na=getRateByNature(tar,nature);
	}
	val=getVal(level,base,ivs,evs,na);
	val=parseInt(val*upstairs);
	con.html(val);
}
//计算所有能力值
function CalAll(event){
	CalHp(event);
	CalVal(event,'at');
	CalVal(event,'df');
	CalVal(event,'sa');
	CalVal(event,'sd');
	CalVal(event,'sp');
	CalAtt(1);
	CalAtt(2);
}
//根据性格判断倍率
function getRateByNature(tar,nature){
	var na=1;
	//nature中的1-5代表五维
	switch(tar){
		case'.at': if(nature[0]==1){
			na=1.1;
		}else if(nature[1]==1){
			na=0.9;
		}
		break;
		case'.df': if(nature[0]==2){
			na=1.1;
		}else if(nature[1]==2){
			na=0.9;
		}
		break;
		case'.sa': if(nature[0]==3){
			na=1.1;
		}else if(nature[1]==3){
			na=0.9;
		}
		break;
		case'.sd': if(nature[0]==4){
			na=1.1;
		}else if(nature[1]==4){
			na=0.9;
		}
		break;
		case'.sp': if(nature[0]==5){
			na=1.1;
		}else if(nature[1]==5){
			na=0.9;
		}
		break;
	}
	return na;
}
//前段计算伤害
function CalAtt(type){
	if (type==1){
		var left='.c-left';
		var right='.c-right';
		var result='.result_att';
	}else{
		var right='.c-left';
		var left='.c-right';
		var result='.result_def';
	}
	var kind=$(left+' .att-kind').val();
	var	att=(kind==1?$(left+' .at .total').text():$(left+' .sa .total').text());
	var	def=(kind==1?$(right+' .df .total').text():$(right+' .sd .total').text());
	var	attname=$($(left+' .chosen-single span')[0]).text();
	var	defname=$($(right+' .chosen-single span')[0]).text();
		hp=$(right+' .hp .total').text();
		skill_type=$(left+' .skill-type').val();
		skill_att=$(left+' .a-skill').val();
		a_item=$(left+' .a-item').val();
		a_ability=$(left+' .a-ability').val();
		att=parseInt(att)*parseInt(a_ability);
		deftype_1=$(right+' .type1').val();
		deftype_2=$(right+' .type2').val();
		atttype_1=$(left+' .type1').val();
		atttype_2=$(left+' .type2').val();
	    level=$(left+' .level').val();
	    type_rise=skill_type==atttype_1||skill_type==atttype_2?1.5:1;
	    if(skill_type!=0){
	    	rate=0.5*getAttackRate(skill_type,deftype_1);
			if(deftype_2!=19){
				rate=rate*0.5*getAttackRate(skill_type,deftype_2);
			}
	    }else{
	    	return;
	    }
	var hurt=1;
	var hurt_cd=0;
	var cloud=$('.att-cloud').val();
	if(cloud==1){
		if(skill_type==10)
		hurt*=1.5;
		else if(skill_type==11)
		hurt*=0.5;
	}else if(cloud==2){
		if(skill_type==11)
		hurt*=1.5;
		else if(skill_type==10)
		hurt*=0.5;
	}else if(cloud==3){
		if((deftype_1==6||deftype_2==6)&&kind==2)
			def*=1.5;
		else if(!getcloudattack(deftype_1,deftype_2,1)){
			//增加沙暴天气伤害
			hurt_cd+=parseInt(0.0625*hp);
		}
	}else if(cloud==4){
		if(!getcloudattack(deftype_1,deftype_2,2)){
			//增加暴雪天气伤害
			hurt_cd+=parseInt(0.0625*hp);
		}
	}
		hurt*=(((parseInt(level)*2/5+2)*parseInt(skill_att)*parseInt(att)/parseInt(def))/50)+2;
		hurt*=rate*type_rise*a_item;
		att=$(result+' .att');
		def=$(result+' .def');
		abi=$(result+' .abi');
		item=$(result+' .item');
		type=$(result+' .type');
		skill=$(result+' .skill');
		hurts=$(result+' .hurt');
		per=$(result+' .per');
	//判断是否存在墙
	if(kind==1&&($(right+'_fs').is(':checked')==true)){
		hurt*=0.5;
		hurt=parseInt(hurt);
	}else if(kind==2&&($(right+'_gq').is(':checked')==true)){
		hurt*=0.5;
		hurt=parseInt(hurt);
	}
	
	//判断对方场上是否存在岩钉
	if($(right+'_yd').is(':checked')==true){
		//存在岩钉
		var rate_yd=0.5*getAttackRate(6,deftype_1);
		if(deftype_2!=19){
				rate_yd=rate_yd*0.5*getAttackRate(6,deftype_2);
		}
		hurt_cd+=parseInt(0.125*hp*rate_yd);
		
	}
	//判断对方场上是否存在地钉
	if($(right+'-dd_value').val()!=0){
		hurt_cd+=parseInt(1/(10-$(right+'-dd_value').val()*2)*hp);
	}
	var truehurt=parseInt(0.85*hurt+hurt_cd)+"~"+parseInt(hurt+hurt_cd)+"("+hp+")";
	var trueper=((0.85*hurt+hurt_cd)/hp*100).toFixed(1)+"%~"+((hurt_cd+hurt)/hp*100).toFixed(1)+"%"
	//truehurt=parseInt(0.85*hurt)+"(技能伤害)"++"~"+parseInt(hurt)+"("+hp+")";
	if(attname!="Choose a Pokemon...")
	att.html(attname);
	if(defname!="Choose a Pokemon...")
	def.html(defname);
	abi.html(a_ability);
	item.html(a_item);
	type.html(type_rise);
	skill.html(rate);
	hurts.html(truehurt);
	per.html(trueper);

}
//计算技能伤害倍率
function getAttackRate(atttype,deftype){
	atttype-=1;
	deftype-=1;
	//0，无效，1，效果不好，2效果一般，4效果拔群
 	var a=new Array(
 		[2,2,2,2,2,1,2,0,1,2,2,2,2,2,2,2,2,2],
 		[4,2,1,1,2,4,1,0,4,2,2,2,2,1,4,2,4,1],
 		[2,4,2,2,2,1,4,2,1,2,2,4,1,2,2,2,2,2],
 		[2,2,2,1,1,1,2,1,0,2,2,4,2,2,2,2,2,4],
 		[2,2,0,4,2,4,1,2,4,4,2,1,4,2,2,2,2,2],
 		[2,1,4,2,1,2,4,2,1,4,2,2,2,2,4,2,2,2],
 		[2,1,1,1,2,2,2,1,1,1,2,4,2,4,2,2,4,1],
 		[0,2,2,2,2,2,2,4,2,2,2,2,2,4,2,2,1,2],
 		[2,2,2,2,2,4,2,2,1,1,1,2,1,2,4,2,2,4],
 		[2,2,2,2,2,1,4,2,4,1,1,4,2,2,4,1,2,2],
 		[2,2,2,2,4,4,2,2,2,4,1,1,2,2,2,1,2,2],
 		[2,2,1,1,4,4,1,2,1,1,4,1,2,2,2,1,2,2],
 		[2,2,4,2,0,2,2,2,2,2,4,1,1,2,2,1,2,2],
 		[2,4,2,4,2,2,2,2,1,2,2,2,2,1,2,2,0,2],
 		[2,2,4,2,4,2,2,2,1,1,1,4,2,2,1,4,2,2],
 		[2,2,2,2,2,2,2,2,1,2,2,2,2,2,2,4,2,0],
 		[2,1,2,2,2,2,2,4,2,2,2,2,2,4,2,2,1,1],
 		[2,4,2,1,2,2,2,2,1,1,2,2,2,2,2,4,4,2],
 		[2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2]
 		);
 	return a[atttype][deftype];
}
//晴天 火系技能伤害*1.5，水系/2,
//雨天 火系/2.水系*1.5
//沙暴 岩地钢不受每回合伤害，岩石tf*1.5
//雪天 冰系不受每回合伤害
function getcloudattack(deftype_1,deftype_2,type){
	var sb=[5,6,9];
	var xt=[15];
	deftype_1=parseInt(deftype_1);
	deftype_2=parseInt(deftype_2);
	if (type==1) {
		if (sb.indexOf(deftype_1)>=0||sb.indexOf(deftype_2)>=0) {
			return true;
		}else{
			return false;
		}
	}else if (type==2) {
		if (xt.indexOf(deftype_1)>=0||xt.indexOf(deftype_2)>=0) {
			return true;
		}else{
			return false;
		}
	}
}

