<?php namespace console\controllers; 

use Yii; use yii\console\Controller; 
use common\rbac\UserRoleRule; 

class RbacController extends Controller {     
     public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // add "createPost" permission
        $createPost = $auth->createPermission('create');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('update');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $deletePost = $auth->createPermission('delete');
        $deletePost->description ="Delete post";
        $auth->add($deletePost);

        // add "user" role
        $user = $auth->createRole('user');
        $user->description ="can change their thing only";
        $auth->add($user);

        // add "admin" role and give this role the "create and update" permission
        $admin = $auth->createRole('admin');
        $admin->description  = "only can view ,change but cannot delete";
        $auth->add($admin);
        $auth->addChild($admin, $createPost);
        $auth->addChild($admin, $updatePost);

        // add "super admin" role and give this role the "delete" permission
        // as well as the permissions of the "admin" role
        $superadmin = $auth->createRole('super admin');
        $superadmin->description  = "can do everthing";
        $auth->add($superadmin);
        $auth->addChild($superadmin, $deletePost);
        $auth->addChild($superadmin, $admin);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        
        $auth->assign($superadmin, 1);
    }
}