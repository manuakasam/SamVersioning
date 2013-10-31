SamVersioning
=============

A Module that eases the implementation of a version control for your entities. Just configure this module to listen
to your "Entity-Save-Events" and you're done - nothing more needed.

Requirements
============

This Module is designed to work out of the Box with Doctrine 2 (```DoctrineORMModule```) and Zend Framework 2. While the
ultimate goal will be to implement the same Features for ```Zend\Db```, too, currently this is not supported.

Installation
============

The easiest way to install this module is through the use of Composer:

```
composer.phar require manuakasam/sam-versioning dev-master
```

Configuration
=============

The configuration is just as simple as the installation. Copy ```/SamVersioning/config/sam-versioning.globa.php.dist```
to your ```/config/autoload``` directory, remove the ```.dist``` extension and modify it's contents to your needs. The
```versionify``` array expects you to attack key=>value pairs of ClassName => EventName. That way SamVersioning will be
able to listen to those Events. An example could be:

```
return array(
    'sam_versioning' => array(
        'versionify' => array(
            'My\Namespaced\Service'    => 'eventname.additem.post',
            'My\Namespaced\Service'    => 'eventname.edititem.post',
            'Other\Namespaced\Service' => 'objecteditted',
        )
    )
);
```

Events? What Events?
====================

In the best scenario you already have your services set up in a way that they provide events that you can easily hook
into. Often times however this is not the case, but changing your Services to provide events is nothing more than two
lines of code. See the following example:

```
namespace MyNS\Services;
class SomeService {
    public function saveEntity($entity) {
        $this->dbMapper->save($entity);
    }
}
```

Like this, SamVersioning can do nothing to keep track of the Version of ```$entity```, so let's modify the code to allow
us to keep track of it:

```
namespace MyNS\Services;
class SomeService {
    public function saveEntity($entity) {
        $this->dbMapper->save($entity);

        $eventManager = new EventManager('MyNS\Services\SomeService');
        $eventManager->trigger('save-entity.post', $this, array('object' => $entity));
    }
}
```

And that's it, a configuration for this Service to be folllowed would be this:


```
return array(
    'sam_versioning' => array(
        'versionify' => array(
            'MyNS\Services\SomeService' => 'save-entity.post'
        )
    )
);
```