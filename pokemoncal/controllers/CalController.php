<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pokemons;
use app\models\PokeInfos;
use app\models\PokeNatures;
use app\models\PokeTypes;

class CalController extends Controller{

	public function actionIndex()
    {
    	$model = new Pokemons;
    	$pokemons=Pokemons::find()->asArray()->all();
    	$natures=PokeNatures::find()->asArray()->all();
        $types=PokeTypes::find()->asArray()->all();
    	//var_dump($natures);
    	//var_dump($pokemons);
        return $this->render('index',[
        	'pokemons' => $pokemons,
        	'natures' => $natures,
            'types' => $types,
        	]);
    }

    public function actionPoke($pmid,$type){
    	$infos=PokeInfos::find()
    		->where([
    		'poke_id' => $pmid,
    		'poke_type' => $type
    		])
    		->asArray()
    		->one();
        $types=PokeTypes::find()->asArray()->all();
        $type1=$infos['type1']-1;
        $type2=$infos['type2']-1;
        $infos['type1_zh']=$types[$type1]['type_name'];
        if($type2!=18){
            $infos['type2_zh']=$types[$type2]['type_name'];
        }else{
            $infos['type2_zh']="";
        }
    	echo json_encode($infos);
    }
}