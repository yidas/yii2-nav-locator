<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Navigation Locator</h1>
    <br>
</p>

Yii 2 Navigation Routing Locator for active menu identification

[![Latest Stable Version](https://poser.pugx.org/yidas/yii2-nav-locator/v/stable?format=flat-square)](https://packagist.org/packages/yidas/yii2-nav-locator)
[![Latest Unstable Version](https://poser.pugx.org/yidas/yii2-nav-locator/v/unstable?format=flat-square)](https://packagist.org/packages/yidas/yii2-nav-locator)
[![License](https://poser.pugx.org/yidas/yii2-nav-locator/license?format=flat-square)](https://packagist.org/packages/yidas/yii2-nav-locator)

FEATURES
--------

- *Smartly **identifying active navigation** on current controller action*

- *Multi-validators for **grouping active navigation***

- *Route **prefix setting** support*

---

OUTLINE
-------

* [Demonstration](#demonstration)
* [Requirements](#requirements)
* [Installation](#installation)
* [Usage](#usage)
    - [is()](#is)
    - [in()](#in)
    - [setPrefix()](#setprefix)

---

DEMONSTRATION
-------------

Giving a 3-layer controller action route structure for Yii 2 framework:

```
yii2/
├── controllers/           
    ├── data/      
        ├── ListController.php
        └── StructureSettingController.php
    ├── datacenters/            
        ├── ClusterSettingController.php
        └── ListController.php
    └── SiteController.php      
```

In the view of global navigation menu, write active conditions by Nav Locator:

```php
<?php
use yidas\NavLocator as Locator;
use yii\helpers\Url;
?>

<li class="treeview <?php if(Locator::in('data/')):?>active menu-open<?php endif ?>">
  <a href="#">
    <i class="fa fa-database"></i> <span>Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php if(Locator::in('data/list')):?>active<?php endif ?>"><a href="<?=Url::to(['data/list'])?>"><i class="fa fa-circle-o"></i> Data List </a></li>
    <li class="<?php if(Locator::in('data/structure-setting')):?>active<?php endif ?>"><a href="<?=Url::to(['data/structure-setting'])?>"><i class="fa fa-circle-o"></i> Structure Setting </a></li>
  </ul>
</li>

<li class="treeview <?php if(Locator::in('datacenters/')):?>active menu-open<?php endif ?>">
  <a href="#">
    <i class="fa fa-server"></i> <span>Data Centers</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php if(Locator::in('datacenters/list/')):?>active<?php endif ?>"><a href="<?=Url::to(['datacenters/list'])?>"><i class="fa fa-circle-o"></i> Node List </a></li>
    <li class="<?php if(Locator::in('datacenters/cluster-setting/')):?>active<?php endif ?>"><a href="<?=Url::to(['datacenters/cluster-setting'])?>"><i class="fa fa-circle-o"></i> Cluster Setting </a></li>
  </ul>
</li>
```

<img src="https://github.com/yidas/yii2-nav-locator/blob/master/img/demo_1-1.png" height="270" /> <img src="https://github.com/yidas/yii2-nav-locator/blob/master/img/demo_1-2.png" height="270" /> <img src="https://github.com/yidas/yii2-nav-locator/blob/master/img/demo_2-1.png" height="270" /> <img src="https://github.com/yidas/yii2-nav-locator/blob/master/img/demo_2-2.png" height="270" />

- Example 1 active URI: `data/list`, `data/list/action`
- Example 2 active URI: `data/structure-setting`, `data/structure-setting/action`
- Example 3 active URI: `datacenters/list`, `datacenters/list/action`
- Example 4 active URI: `datacenters/cluster-setting`, `datacenters/cluster-setting/action`

Nav Locator even supports route rule mapping. If you have a rule `'test' => 'data/list'`, the Nav Locator could identify as in `data/list` when you enter with `test` route.

---

REQUIREMENTS
------------

This library requires the following:

- PHP 5.4.0+
- Yii 2.0.0+

---


INSTALLATION
------------

Install via Composer in your Yii2 project:

```
composer require yidas/yii2-nav-locator
```

---


USAGE
-----

### is()

Validate current controller action is completely matched giving route

```php
public static boolean is(string $route)
```

*Example:*

Suppose `site/index` as the current controller action:

```php
use yidas\NavLocator as Locator;

Locator::is('site');            // False 
Locator::is('site/');           // False 
Locator::is('site/index');      // True 
Locator::is('site/index/');     // True 
Locator::is('site/other');      // False 
Locator::is('site/other/');     // False 
```

> The giving route need to be defined precisely, the format is `module-ID/controller-ID/action-ID`.

### in()

Validate current controller action is under giving route

```php
public static boolean in(string $route)
```

*Example:*

Suppose `site/index` as the current controller action:

```php
use yidas\NavLocator as Locator;

Locator::in('site');            // True 
Locator::in('site/');           // True 
Locator::in('site/index');      // True 
Locator::in('site/index/');     // True 
Locator::in('site/other');      // False 
Locator::in('site/other/');     // False 
Locator::in('si');              // False 
Locator::in('si/');             // False 
```

### setPrefix()

Set prefix route for simplifying declaring next locator routes 

```php
public static self setPrefix(string $prefix)
```

*Example:*

```php
<?php
use yidas\NavLocator as Locator;
?>

<li class="treeview <?php if(Locator::setPrefix('data/')->in('/')):?>active menu-open<?php endif ?>">
  <a href="#">
    <i class="fa fa-database"></i> <span>Data</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php if(Locator::in('list/')):?>active<?php endif ?>"><a href="<?=Url::to(['data/list'])?>"><i class="fa fa-circle-o"></i> Data List </a></li>
    <li class="<?php if(Locator::in('structure-setting/')):?>active<?php endif ?>"><a href="<?=Url::to(['data/structure-setting'])?>"><i class="fa fa-circle-o"></i> Structure Setting </a></li>
  </ul>
</li>

<li class="treeview <?php if(Locator::setPrefix('datacenters/')->in('/')):?>active menu-open<?php endif ?>">
  <a href="#">
    <i class="fa fa-server"></i> <span>Data Centers</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php if(Locator::in('list/')):?>active<?php endif ?>"><a href="<?=Url::to(['datacenters/list'])?>"><i class="fa fa-circle-o"></i> Node List </a></li>
    <li class="<?php if(Locator::in('cluster-setting/')):?>active<?php endif ?>"><a href="<?=Url::to(['datacenters/cluster-setting'])?>"><i class="fa fa-circle-o"></i> Cluster Setting </a></li>
  </ul>
</li>
```

> You could call it without parameter for reset prefix: `\yidas\NavLocator::setPrefix()` 
