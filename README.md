DevDrivePagerBundle
===================

A simple pager. Its uses doctrine paginator, extending it with some extra functionality.
See "DevDrive\PagerBundle\Service\DoctrinePager.php"  php doc comments for more info.

How to use
----------

in controller action
```php
$page = 1;

$pager = $this->get('pager.doctrine');
$em = $this->getDoctrine()->getEntityManager();

$q = $em->createQuery("SELECT p FROM AppEntityBundle:Post p")

$pager->init($query, $page, 10);

foreach ($pager as $row)
{
   // ...
}
```