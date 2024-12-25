<?php        	
namespace TT\Hello\Block\Html;
 /**
 * Html page top menu block
*/
 class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
	
/**
* Recursively generates top menu html from data that is specified in $menuTree
 *
 * @param \Magento\Framework\Data\Tree\Node $menuTree
 * @param string $childrenWrapClass
 * @param int $limit
 * @param array $colBrakes
 * @return string
 *
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 */
protected function _getHtml(
	\Magento\Framework\Data\Tree\Node $menuTree,
	$childrenWrapClass,
	$limit,
	array $colBrakes = []
 ) {
   global $magmenu, $click, $stretch, $horzmenu;;
   $html = '';
   $cvalue = 'data-toggle="dropdown"';
   $key = 1;

   $children = $menuTree->getChildren();
   $parentLevel = $menuTree->getLevel();
   $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

	$counter = 1;
	$itemPosition = 1;
	$childrenCount = $children->count();
	
	$parentPositionClass = $menuTree->getPositionClass();
	$itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

    foreach ($children as $child) {
      $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
      if($child->hasChildren()){
        if($child->getIsActive()){
        	if($stretch)
        	{
        	$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
        	. $this->escapeHtml($child->getName()) . '</a><hr class="horiz_separator" />';
        	}
        	else
        	{
        	$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
        	. $this->escapeHtml($child->getName()) . '</a>';
        	if ($key != $childrenCount)
        	{
        		$html .='<hr class="horiz_separator" />';
        	}
        	}
        	}
        	else{		
        	 if($stretch)
        		 {
        		  $html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
        			 	. $this->escapeHtml($child->getName()) . '</a><hr class="horiz_separator" />';
        		  }
        	 else
        		 {
        			 $html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_arrow dropdown-toggle"'. $cvalue .'><span class="menuchildicon"></span>'
        			  	. $this->escapeHtml($child->getName()) . '</a>';
        			 if ($key != $childrenCount)
        			  {
        			    $html .='<hr class="horiz_separator" />';
        			   }
        		 }
        	 }
        				
        	 	$childrenlevel1=$child->getChildren();
        	    $html .= $this->_generate_level1_children($childrenlevel1);
        		$html .= "</li>";
        	 }
        	 else{
        		 if($child->getIsActive()){
        					
        			 if($stretch)
        				 {
        				   $html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active"><span class="menuchildicon"></span>'
        							. $this->escapeHtml($child->getName()) . '</a><hr class="horiz_separator" />';
        				 }
        				 else
        				 {
        					 $html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link_active"><span class="menuchildicon"></span>'
        					 . $this->escapeHtml($child->getName()) . '</a>';
        					 
        					 if ($key != $childrenCount)
        						{
        							$html .='<hr class="horiz_separator" />';
        						}
        					}
        				}
        				else{
        					
        					if($stretch)
        					{
        						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link"><span class="menuchildicon"></span>'
        							. $this->escapeHtml($child->getName()) . '</a><hr class="horiz_separator" />';
        					}
        					else
        					{
        						$html .= '<a href="' . $child->getUrl() . '" class="ttr_menu_items_parent_link"><span class="menuchildicon"></span>'
        							. $this->escapeHtml($child->getName()) . '</a>';
        						if ($key != $childrenCount)
        						{
        							$html .='<hr class="horiz_separator" />';
        						}
        					}
        				}
        			}
        			
        	$itemPosition++;
        	$counter++;
        	
        	$html .= '</li>';
        	$key++;
  }
 return $html;
}
        	
protected function _generate_level1_children($children)
 {
	global $magmenu, $stretch, $horzmenu;
    $count = $children->count();
    $key = 1;
        		
    $output='';
    $output.='<ul class="child dropdown-menu" role="menu">';
    
    foreach($children as $tree_item)
      		{
        		if ($magmenu)
        		{
        			$output.='<li class="span1 unstyled dropdown dropdown-submenu" >';
        		}
        		else
        		{
        			$output.='<li class="dropdown dropdown-submenu">';
        		}
        		
        		if($tree_item->hasChildren())
        			{        				
        				if($stretch)
        				{
        					$output.= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a><hr class="separator" />';
        				}
        				else
        				{
        					$output.= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
        					if ($magmenu || $horzmenu)
        					{
        						$output.='<hr class="separator" />';
        					}
        					else
        					{
        						if($key != $count)
        						{
        							$output.='<hr class="separator" />';
        						}
        					}
        				}
        				
        				$childrenlevel2=$tree_item->getChildren();
        				$output.= $this->_generate_level2_children($childrenlevel2);
        			}
        			else{ 
        				
        				if($stretch)
        				{
        					$output.='<a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a><hr class="separator" />';
        				}
        				else
        				{
        					$output.='<a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
        					if ($magmenu || $horzmenu)
        					{
        						$output.='<hr class="separator" />';
        					}
        					else
        					{
        						if($key != $count)
        							$output.='<hr class="separator" />';
       					}
       				}
       			}
       			$output.='</li >';
      			$key++;
      		}
   		$output.='</ul>';
   		return $output;
}
        	
protected function _generate_level2_children($children)
{
	global $magmenu;
    global $stretch;
    global $horzmenu;
    $count = $children->count();
    $key = 1;
    $output='';
        		
     if ($magmenu)
     	{
     	$output.='<ul role="menu">';
     	}
     elseif ($horzmenu)
     	{
     	$output.='<ul class="sub-menu" role="menu">';
     	}
     	else
     	{
     	$output.='<ul class="dropdown-menu sub-menu menu-dropdown-styles" role="menu">';
     	}
        		
     	foreach($children as $tree_item)
     		{
        	 if($tree_item->hasChildren())
        		{
        		if($stretch)
        		{
        			$output.= '<li class="dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a><hr class="separator" />';
        		}
        		else
        		{
        			$output.= '<li class="dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
        			if ($magmenu || $horzmenu)
        				{
        					$output.='<hr class="separator" />';
        				}
        				else
        				{
        					if($key != $count)
        					$output.='<hr class="separator" />';
        				}
        			}
        				
        				$childrenlevel3=$tree_item->getChildren();
        				$output.= $this->_generate_level2_children($childrenlevel3);
        				$output.= '</li>';
        				
        			}
        			else{
        				
        				
        				if($stretch)
        				{
        					$output.='<li><a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a><hr class="separator" />';
        				}
        				else
        				{
        					$output.='<li><a href="'.$tree_item->getUrl(). '"><span class="menuchildicon"></span>'.$this->escapeHtml($tree_item->getName()). '</a>';
        					if ($magmenu || $horzmenu)
        					{
        						$output.='<hr class="separator" />';
        					}
        					else
        					{
        						if($key != $count)
        							$output.='<hr class="separator" />';
        					}
        				}
        				$output.= '</li>';
        			}
        			$key++;
        		}
   		$output.='</ul>';
   		return $output;
}

        	/**
        	 * Generates string with all attributes that should be present in menu item element
        	 *
        	 * @param \Magento\Framework\Data\Tree\Node $item
        	 * @return string
        	 */
        	protected function _getRenderedMenuItemAttributes(\Magento\Framework\Data\Tree\Node $item)
        	{
        		$html = '';
        		$attributes = $this->_getMenuItemAttributes($item);
        		foreach ($attributes as $attributeName => $attributeValue) {
        			$html .= ' ' . $attributeName . '="' . str_replace('"', '\"', $attributeValue) . '"';
        		}
        		return $html;
        	}

/**
 * Returns array of menu item's attributes
 *
 * @param \Magento\Framework\Data\Tree\Node $item
* @return array
*/
protected function _getMenuItemAttributes(\Magento\Framework\Data\Tree\Node $item)
 {
   		$menuItemClasses = $this->_getMenuItemClasses($item);
   		return ['class' => implode(' ', $menuItemClasses)];
 }

/**
 * Returns array of menu item's classes
 *
 * @param \Magento\Framework\Data\Tree\Node $item
 * @return array
 */
protected function _getMenuItemClasses(\Magento\Framework\Data\Tree\Node $item)
 {
  $classes = [];
  $classes[] = 'ttr_menu_items_parent dropdown';
    		
  $classes[] = 'level' . $item->getLevel();
  $classes[] = $item->getPositionClass();

    if ($item->getIsFirst()) {
    $classes[] = 'first';
    }

    if ($item->getIsActive()) {
    $classes[] = 'active';
     } elseif ($item->getHasActive()) {
    $classes[] = 'has-active';
     }

    if ($item->getIsLast()) {
       $classes[] = 'last';
  	}

   if ($item->getClass()) {
       $classes[] = $item->getClass();
    }

	if ($item->hasChildren()) {
    $classes[] = 'parent';
    }
     		return $classes;
  	}
 }