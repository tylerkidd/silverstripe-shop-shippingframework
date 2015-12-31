<?php
class ShippingMethodAdmin extends ModelAdmin
{

    public static $url_segment = "shipping-option";
    public static $menu_title = "Shipping";
    public static $menu_priority = 0;

    public static $managed_models = array(
        'ShippingMethod' => array(
            'collection_controller' => 'ShippingMethodAdmin_CollectionController'
        )
    );

    public static $model_importers = array();
}

class ShippingMethodAdmin_CollectionController extends ModelAdmin_CollectionController
{
    
    public function CreateForm()
    {
        $form = parent::CreateForm();
        $options = ClassInfo::subclassesFor("ShippingMethod");
        unset($options[0]);
        $form->Fields()->push(new DropdownField("CustomModelClass", "Type", $options));
        return $form;
    }
    
    //hacks to allow creating a different class of model within the same collection controller
        //get correct CMSFields -> AddForm
        //create correct model -> doCreate

    public function __construct($parent, $model)
    {
        parent::__construct($parent, $model);
        $this->backupModelClass = $this->modelClass;
    }
    
    public function add($request)
    {
        $this->storeCustomModelClass();
        return parent::add($request);
    }
    
    //pass selected model class into form
    public function AddForm()
    {
        if ($customclass = $this->retrieveCustomModelClass()) {
            $this->modelClass = $customclass;
        }
        $form = parent::AddForm();
        $this->modelClass = $this->backupModelClass;
        return $form;
    }
    
    public function doCreate($data, $form, $request)
    {
        if ($customclass = $this->retrieveCustomModelClass()) {
            $this->modelClass = $customclass;
        }
        $output = parent::doCreate($data, $form, $request);
        $this->clearCustomModelClass();
        return $output;
    }
    
    protected function storeCustomModelClass()
    {
        if (isset($_REQUEST['CustomModelClass']) && ClassInfo::is_subclass_of($_REQUEST['CustomModelClass'], $this->modelClass)) {
            Session::set($this->class.".CustomModelClass", $_REQUEST['CustomModelClass']);
        }
    }
    protected function retrieveCustomModelClass()
    {
        return Session::get($this->class.".CustomModelClass");
    }
    protected function clearCustomModelClass()
    {
        Session::clear($this->class.".CustomModelClass");
        $this->modelClass = $this->backupModelClass;
    }
}
