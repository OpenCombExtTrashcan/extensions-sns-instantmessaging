<?php
// ***********************************************************************
// | IM即时通讯 
// ***********************************************************************
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.X )
// ***********************************************************************
// | Author: wangwenbin 
// ***********************************************************************
// | Date: 2011.7.6 
// ***********************************************************************
// 1.0.0.1 
namespace oc\ext\instantmessaging;

//调用共通类
use jc\mvc\model\db\orm\PrototypeAssociationMap;

use jc\db\DB ;
use jc\db\PDODriver ;

use oc\ext\Extension;

/**
 *   IM即时通讯orm
 *   @package    InstantMessaging
 *   @author     wangwenbin
 *   @created    2011.7.6
 *   @history     
 */
class InstantMessaging extends Extension
{
	
    /**
     *    加载方法
     *    @param      null
     *    @package    InstantMessaging 
     *    @return     null
     *    @author     wangwenbin
     *    @created    2011.7.6
     */
    public function load()
    {

    	//ajax请求的url里面 需要用 noframe=1
    	//模型关系实例
        $aAssocMap = PrototypeAssociationMap::singleton();
        //instantmessaging_user模型关系
        $aAssocMap->addOrm(
                array(
                    'keys' => 'id', //主键
                    'table' => 'user', //数据库表的名称，默认为orm名称                                                  
                    'belongsTo' => array(
                        //与userconfig关系
                        array(
                            'prop' => 'config', //属性名称（暂时这么理解）
                            'fromk' => 'id', //主键
                            'tok' => 'userid', //外键
                            'model' => 'userconfig'  //模型名称
                        ),
                    ), 
                    'hasAndBelongsToMany' => array(
                        //与userfriend关系
                        array(
                            'prop' => 'friend', //属性名
                            'fromk' => 'id', //主键
                            'btok' => 'subscribeid', //外键
                            'bfromk' => 'subscribeid', //从主键
                            'tok' => 'userid', //从外键
                            'bridge' => 'subscribe', //从模型名称
                            'model' => 'userfriend', //模型名称
                        ),
                        
                    ),
                )
        );
        
        //userconfig模型关系
        $aAssocMap->addOrm(
            	array(
            		'keys' => 'id' ,
            		'table' => 'userconfig' ,
            		'belongsTo' => array(
            			array(
            				'prop' => 'user' ,
            				'fromk' => 'userid' ,
            				'tok' => 'id' ,
            				'model' => 'user'
            			),
            		),
            	)
            );
        
        $aAssocMap->addOrm(
                array(
                    'keys' => 'id', //主键
                    'table' => 'userfriend', //模型名称
                    
                    'hasAndBelongsToMany' => array(
                        //与关系
                        array(
                            'prop' => 'user', //属性名
                            'fromk' => 'useridid', //主键
                            'btok' => 'subscribeid', //外键
                            'bfromk' => 'subscribeid', //从主键
                            'tok' => 'id', //从外键
                            'bridge' => 'subscribe', //从模型名称
                            'model' => 'user', //模型名称
                        )
                    ),
                )
        );        
        
        
       //im的登录
       $this->application()->accessRouter()->addController("oc\\ext\\instantmessaging\\Login",'login','instantmessaging');//地址，名称，区别
        
        

    }
                
    
}

?>