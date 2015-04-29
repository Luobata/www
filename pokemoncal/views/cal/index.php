<?php
use yii\helpers\Html;
use app\assets\CalAsset;
CalAsset::register($this);
?>
<div class="coontent">
			<div class="c-left con">
					<table>
						<tr>
							<td>PM：	</td>
							<td> 
								 <select data-placeholder="Choose a Pokemon..." class="chosen-select pm-select" style="width:250px;" tabindex="2" id="pk1">
						            <option value=""></option>
						            <?php foreach ($pokemons as $key => $value) {?>
						            <option value="<?php echo $value['pmid'];echo ",";echo $value['type'];?>" ><?php echo $value['name'];?></option>
						            <?php } ?>
						          </select>
						          <input type="hidden" value='1' class="id">
							</td>
						</tr>
						<tr>
							<td>等级：</td>
							<td>
								<input type="text" value="100" name="level" class="level" id="level" oninput="maxlevel(event)" />
			         		<span>(小于100的正整数)</span>
							</td>
						</tr>
						<tr>
							<td>属性：</td>
							<td class="type"></td>
							<input type="hidden" class="type1" value="0">
							<input type="hidden" class="type2" value="0">
						</tr>
					</table>	
					<!--名字框 下拉带搜索-->
					
			         <div class="info-group">
		                <table>
		                    <tr><th></th><th>种族</th><th class="gen-specific g3 g4 g5 g6">个体</th><th class="gen-specific g3 g4 g5 g6">努力</th><th></th><th></th></tr>
		                    <tr class="hp">
		                    	<td><label>HP</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">341</span></td><td></td></tr>
		                    <tr class="at">
		                    	<td><label>Attack</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="252" /></td>
		                    	<td><span class="total">299</span></td><td>
		                    		<select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="df">
		                    	<td><label>Defense</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sa gen-specific g2 g3 g4 g5 g6">
		                    	<td><label>Sp. Atk</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="252" /></td>
		                    	<td><span class="total">299</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sd gen-specific g2 g3 g4 g5 g6">
		                    	<td><label>Sp. Def</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sp"><td><label>Speed</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                </table>
		                <table class="info">
		                	<tr>
		                		<td>性格：</td>
		                		<td>
							          <select data-placeholder="选择性格" class="chosen-select nature-select" style="width:125px;" tabindex="2">
							            <option value=""></option>
							            <?php foreach ($natures as $key => $value) { ?>
							            <option value="<?php echo $value['value'];?>"><?php echo $value['name'];?>(<?php echo $value['specific'];?>)</option>
							            <?php }?>
							          </select>
							          <input type="hidden" class="nature" value="0">
		                		</td>
		                		<td rowspan="6">
		                			<img  src="img/pm/0.png" />
		                		</td>
		                	</tr>
		                	
		                	<tr>
		                		<td>特性加成：</td>
		                		<td><input type="text" value="1" class="a-ability"></td>
		                	</tr>
		                	<tr>
		                		<td>道具加成：</td>
		                		<td><input type="text" value="1" class="a-item"></td>
		                	</tr>
		                	<tr>
		                		<td>技能属性：</td>
		                		<td>
							          <select data-placeholder="选择属性" class="chosen-select type-select" style="width:125px;" tabindex="2">
							            <option value=""></option>
							            <?php foreach ($types as $key => $value) { ?>
							            <option value="<?php echo $value['id'];?>"><?php echo $value['type_name'];?></option>
							            <?php }?>
							          </select>
							          <input type="hidden" class="skill-type" value='0'>
		                		</td>
		                	</tr>
		                	<tr>
		                		<td>技能威力：</td>
		                		<td><input type="text" value="90" class="a-skill"></td>
		                	</tr>
		                	
		                	
		                </table>
		                
		                
		            </div>
		            <div class="col-xs-3" style="width:100%;">
						        
						          <label class="radio">
						            <input type="radio" name="optionsRadios" class="kind" id="wl" value="1" data-toggle="radio" checked="">
						            物理
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios" class="kind" id="ts" value="2" data-toggle="radio" >
						            特殊
						          </label>
						          <input type="hidden" value="1" class="att-kind">
					</div>
			          
			</div>
			
			
			<div class="c-right con">
				<table>
						<tr>
							<td>PM：	</td>
							<td> 
								 <select data-placeholder="Choose a Pokemon..." class="chosen-select pm-select" style="width:250px;" tabindex="2" id="pk1">
						            <option value=""></option>
						            <?php foreach ($pokemons as $key => $value) {?>
						            <option value="<?php echo $value['pmid'];echo ",";echo $value['type'];?>" ><?php echo $value['name'];?></option>
						            <?php } ?>
						          </select>
						          <input type="hidden" value='1' class="id">
							</td>
						</tr>
						<tr>
							<td>等级：</td>
							<td>
								<input type="text" value="100" name="level" class="level" id="level" oninput="maxlevel(event)" />
			         		<span>(小于100的正整数)</span>
							</td>
						</tr>
						<tr>
							<td>属性：</td>
							<td class="type"></td>
							<input type="hidden" class="type1" value="0">
							<input type="hidden" class="type2" value="0">
						</tr>
					</table>	
					<!--名字框 下拉带搜索-->
					
			         <div class="info-group">
		                <table>
		                    <tr><th></th><th>种族</th><th class="gen-specific g3 g4 g5 g6">个体</th><th class="gen-specific g3 g4 g5 g6">努力</th><th></th><th></th></tr>
		                    <tr class="hp">
		                    	<td><label>HP</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="252" /></td>
		                    	<td><span class="total">404</span></td><td></td></tr>
		                    <tr class="at">
		                    	<td><label>Attack</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td>
		                    		<select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="df">
		                    	<td><label>Defense</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="252" /></td>
		                    	<td><span class="total">299</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sa gen-specific g2 g3 g4 g5 g6">
		                    	<td><label>Sp. Atk</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sd gen-specific g2 g3 g4 g5 g6">
		                    	<td><label>Sp. Def</label></td><td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="252" /></td>
		                    	<td><span class="total">299</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                    <tr class="sp"><td><label>Speed</label></td>
		                    	<td><input class="base calc-trigger" value="100" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="ivs calc-trigger" value="31" /></td>
		                    	<td class="gen-specific g3 g4 g5 g6"><input class="evs calc-trigger" type="number" min="0" max="252" step="4" value="0" /></td>
		                    	<td><span class="total">236</span></td><td><select class="boost calc-trigger"><option value="6">+6</option><option value="5">+5</option><option value="4">+4</option><option value="3">+3</option><option value="2">+2</option><option value="1">+1</option><option value="0" selected="selected">--</option><option value="-1">-1</option><option value="-2">-2</option><option value="-3">-3</option><option value="-4">-4</option><option value="-5">-5</option><option value="-6">-6</option></select></td></tr>
		                </table>
		               <table class="info">
		                	<tr>
		                		<td>性格：</td>
		                		<td>
							          <select data-placeholder="选择性格" class="chosen-select nature-select" style="width:125px;" tabindex="2">
							            <option value=""></option>
							            <?php foreach ($natures as $key => $value) { ?>
							            <option value="<?php echo $value['value'];?>"><?php echo $value['name'];?>(<?php echo $value['specific'];?>)</option>
							            <?php }?>
							          </select>
							          <input type="hidden" class="nature" value="0">
		                		</td>
		                		<td rowspan="6">
		                			<img  src="img/pm/0.png" />
		                		</td>
		                	</tr>
		                	
		                	<tr>
		                		<td>特性加成：</td>
		                		<td><input type="text" value="1" class="a-ability"></td>
		                	</tr>
		                	<tr>
		                		<td>道具加成：</td>
		                		<td><input type="text" value="1" class="a-item"></td>
		                	</tr>
		                	<tr>
		                		<td>技能属性：</td>
		                		<td>
							          <select data-placeholder="选择属性" class="chosen-select type-select" style="width:125px;" tabindex="2">
							            <option value=""></option>
							            <?php foreach ($types as $key => $value) { ?>
							            <option value="<?php echo $value['id'];?>"><?php echo $value['type_name'];?></option>
							            <?php }?>
							          </select>
							          <input type="hidden" class="skill-type" value='0'>
		                		</td>
		                	</tr>
		                	<tr>
		                		<td>技能威力：</td>
		                		<td><input type="text" value="90" class="a-skill"></td>
		                	</tr>
		                	
		                	
		                </table>
		                
		                
		            </div>
		            <div class="col-xs-3" style="width:100%;">
						        
						          <label class="radio">
						            <input type="radio" name="optionsRadios_def" class="kind" id="wl" value="1" data-toggle="radio" checked="">
						            物理
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_def" class="kind" id="ts" value="2" data-toggle="radio" >
						            特殊
						          </label>
						          <input type="hidden" value="1" class="att-kind">
					</div>
		            
			</div>
			<div class="c-center cd">
				<div class="cloud">
					<div class="col-xs-3" style="width:100%;">
						          <label class="radio">
						            <input type="radio" name="optionsRadios_cloud"  class="clouds" id="wl" value="0" data-toggle="radio" checked="">
						            无
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_cloud" class="clouds" id="ts" value="1" data-toggle="radio" >
						            干旱
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_cloud" class="clouds" id="ts" value="2" data-toggle="radio" >
						            降雨
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_cloud" class="clouds" id="ts" value="3" data-toggle="radio" >
						            沙暴
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_cloud" class="clouds" id="ts" value="4" data-toggle="radio" >
						            冰雹
						          </label>
						          <input type="hidden" value="0" class="att-cloud">
					</div>
				</div>
				<div>
					
					<div class="col-xs-3" style="width:100%;">
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_att"  class="c-left-dd" id="wl" value="0" data-toggle="radio" checked="">
						            无(攻击方地钉)
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_att" class="c-left-dd" id="ts" value="1" data-toggle="radio" >
						            一把
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_att" class="c-left-dd" id="ts" value="2" data-toggle="radio" >
						            两把
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_att" class="c-left-dd" id="ts" value="3" data-toggle="radio" >
						            三把
						          </label>
						          <input type="hidden" value="0" class="c-left-dd_value">
					</div>
					<div class="col-xs-3" style="width:100%;">
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_def"  class="c-right-dd" id="wl" value="0" data-toggle="radio" checked="">
						            无(防御方地钉)
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_def" class="c-right-dd" id="ts" value="1" data-toggle="radio" >
						            一把
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_def" class="c-right-dd" id="ts" value="2" data-toggle="radio" >
						            两把
						          </label>
						          <label class="radio">
						            <input type="radio" name="optionsRadios_dd_def" class="c-right-dd" id="ts" value="3" data-toggle="radio" >
						            三把
						          </label>
						          <input type="hidden" value="0" class="c-right-dd_value">
					</div>
				</div>
				<div class="yd">
					 <div class="col-md-6">
		                <label class="checkbox" for="checkbox1">
		                  <input type="checkbox" value="" id="checkbox1" class="c-left_yd" data-toggle="checkbox">
		                  隐秘岩石（攻击方场地）
		                </label>
		                <label class="checkbox" for="checkbox2">
		                  <input type="checkbox" value="" id="checkbox2" class="c-right_yd" data-toggle="checkbox">
		                  隐秘岩石（防御方场地）
		                </label>
		                <label class="checkbox" for="checkbox3">
		                  <input type="checkbox" value="" id="checkbox3" class="c-left_fs" data-toggle="checkbox">
		                  反射盾（物理，攻击方场地）
		                </label>
		                <label class="checkbox" for="checkbox4">
		                  <input type="checkbox" value="" id="checkbox4" class="c-right_fs" data-toggle="checkbox">
		                  反射盾（物理，防御方场地）
		                </label>
		                <label class="checkbox" for="checkbox5">
		                  <input type="checkbox" value="" id="checkbox5" class="c-left_gq" data-toggle="checkbox">
		                  光墙（特殊，攻击方场地）
		                </label>
		                <label class="checkbox" for="checkbox6">
		                  <input type="checkbox" value="" id="checkbox6" class="c-right_gq" data-toggle="checkbox">
		                  光墙（特殊，防御方场地）
		                </label>
		                
		              </div>
				</div>
			</div>
			<div class="c-cencter">
				<div class="result_att">
					<table>
						<tr>
							<td>攻击方：</td>
							<td class="att"></td>
						</tr>
						<tr>
							<td>防御方：</td>
							<td class="def"></td>
						</tr>
						<!-- <tr>
							<td>特性加成:</td>
							<td class="abi"></td>
						</tr>
						<tr>
							<td>道具加成：</td>
							<td class="item"></td>
						</tr> -->
						<tr>
							<td>属性加成：</td>
							<td class="type"></td>
						</tr>
						<tr>
							<td>技能倍率:</td>
							<td class="skill"></td>
						</tr>
						<tr>
							<td>造成伤害:</td>
							<td class="hurt"></td>
						</tr>
						<tr>
							<td>百分比:</td>
							<td class="per"></td>
						</tr>
					</table>
				</div>
			</div>

			<div class="c-cencter">
				<div class="result_def">
					<table>
						<tr>
							<td>攻击方：</td>
							<td class="att"></td>
						</tr>
						<tr>
							<td>防御方：</td>
							<td class="def"></td>
						</tr>
						<!-- <tr>
							<td>特性加成:</td>
							<td class="abi"></td>
						</tr>
						<tr>
							<td>道具加成：</td>
							<td class="item"></td>
						</tr> -->
						<tr>
							<td>属性加成：</td>
							<td class="type"></td>
						</tr>
						<tr>
							<td>技能倍率:</td>
							<td class="skill"></td>
						</tr>
						<tr>
							<td>造成伤害:</td>
							<td class="hurt"></td>
						</tr>
						<tr>
							<td>百分比:</td>
							<td class="per"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
