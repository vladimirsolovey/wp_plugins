<?php
/**
  * Date: 13.02.17
 * Time: 15:09
 */

namespace wichita_webmasters_acpt\http;


    class ACPTRolesService extends BaseClass
    {

        private $post_type;
        private $roles;
        function __construct($post_type_name)
        {
            global $wp_roles;
            parent::__construct();
            $this->roles = $wp_roles->roles;
            $this->post_type = $this->db_ctx->getCustomPosts()->getCustomPostByName($post_type_name);
        }

        function show()
        {

            $roles_list =$this->roles;

            return array("roles"=>$roles_list,'post_type'=>$this->post_type);
        }

        function edit()
        {


            if($this->request->get('wwm-save')!=null && !$this->is_empty($this->request->get('wwm-save')) && $this->request->get('wwm-save')==1)
            {
                $roleInfo_edit = get_role($_REQUEST['role']);

                foreach($_REQUEST['cap'] as $key=>$val)
                {

                    if((boolean)$val) {
                        $roleInfo_edit->add_cap($key,true);
                    }else
                    {
                        $roleInfo_edit->add_cap($key,false);
                    }
                }
                $this->success[]='Capabilities updated successfully';
            }

            $roleInfo = get_role($_REQUEST['role']);

            $caps = $this->post_type->getCapabilities();
            $capsList=array();
            foreach($caps as $key=>$val)
            {
                if(in_array($val,array_keys($roleInfo->capabilities)))
                {
                    $capsList[$val]=$roleInfo->capabilities[$val];
                }
                else
                {
                    $capsList[$val]=false;
                }
            }

            return array('view'=>'custom-post-roles/edit', "roleInfo"=>$roleInfo,'capsList'=>$capsList);
            //return array('view'=>'custom-post-roles/edit');
        }
        function getPostType()
        {
            return $this->post_type;
        }
        function setManager()
        {
            $_REQUEST['a'] = (isset($_REQUEST['a']) && !empty($_REQUEST['a'])) ? $_REQUEST['a'] : 'show';
            switch($_REQUEST['a'])
            {
                case 'show':
                    $this->response_params = $this->show();
                    break;
                case 'add':
                    $this->response_params = $this->add();
                    break;
                case 'edit':
                    $this->response_params = $this->edit();
                    break;
                case 'del':
                    $this->response_params = $this->del();
                    break;
                case 'edit-roles':
                    $this->response_params = $this->editRoles();
                    break;
            }
            if(!isset($this->response_params['view']))
            {
                $this->response_params['view'] = 'custom-post-roles/list';
            }
            if(!isset($this->response_params['query']))
            {
                $this->response_params['query'] = array();
            }
            return $this->response_params;
        }
    }