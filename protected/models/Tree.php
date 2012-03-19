<?php
/*
Tree class Ver 2.0 (28/09/2011)

This class read tree data from MySQL table and build the tree
structure accordingly.

History:
- 03/01/2006 (Lee Peng) :: Standard functions
- 09/12/2009 (Sheau Jye) :: Ported to New Forecepts Framework
- 28/09/2011 (Elliot) :: Ported to Yii Framework
*/

class Tree {
	/*
	NOTE: 
		- a tree node is an array with all fields read from the database table
			and an additional key "fcChildren": an array storing all the children IDs.
		- Please take note that this script make use of "fcChildren" as key. So
			please try to avoid naming any field as fcChildren
	*/
	public $arr_nodes;	//array to store all nodes
	private $idField;
	private $parentIdField;
	private $order_nodes;
	
	/*
	Constructor:
	Build the tree structure with children and parent relationship
	*/
	public function Tree( $table, $idField ='id',$parentIdField='parent_id',$sortField='pos')	{
		$this->idField = $idField;
		$this->parentIdField = $parentIdField;
		
		# $sql = "SELECT * FROM $table ORDER BY $parentIdField, $sortField";
		# $rs = $db->query($sql);
		$result = Yii::app()->db->createCommand()
			->select('*')
			->from($table.' a')
			#->join(' b', 'a.id=b._id')
			#->where('id=:id', array(':id'=>$id))
			->order('parent_id,'.$sortField)
			->queryAll();
		
		
		// Building root node at index 0 (root)
		$this->arr_nodes[0] = array(
			$idField		=> 0,
			'name'			=> 'ROOT',
			$parentIdField	=> -1,
			'fcChildren'	=> array()
		);
		
		
		//store all node information to $arr_nodes
		foreach ($result as $key => $node) {
			$node['fcChildren'] = array();
			$this->arr_nodes[$node[$idField]] = $node;
		}

		
		//associate parent and children
		foreach ($this->arr_nodes as $node)	 {
			if ($node[$parentIdField] >= 0) {
				if (isset($this->arr_nodes[$node[$parentIdField]]))
					$this->arr_nodes[$node[$parentIdField]]["fcChildren"][] = $node[$idField];
			}
		}
		
		// Add fcLevel to nodes
		$nodes = $this->inOrder();
		foreach ($nodes as $item) {
			$this->arr_nodes[$item['id']]['fcLevel'] = $item['fcLevel'];
		}
		
		$this->order_nodes = $this->inOrder();

	}//endof constructor
	
	
	// Get node info
	public function nodeInfo($id) {
		return $this->arr_nodes[$id];
	}
	
	
	/*
	In-Order traversal of nodes
	*/
	public function inOrder($startNode=0, $level=1)	 {
		/*
		This function returns an array with the nodes arranged accordingly
		E.g.
		A
		+--A1
		+--A2
				+--A2-1
				+--A2-2
		B
		+--B1
		The return array is arranged as 
		0=>A, 1=>A1, 2=>A2, 3=>A2-1, 4=>A2-2, 5=>B, 6=>B1
		an additional key "fcLevel" is used to determine the level of the node.
		E.g. A is 1, A1 and A2 is 2...
		*/
		
		$arr_return = array();
		
		$node = $this->arr_nodes[$startNode];
		$node["fcLevel"] = $level;
		$arr_return[] = $node;

		for ($i=0; $i<count($node["fcChildren"]); $i++)
			$arr_return = array_merge($arr_return,$this->inOrder($node["fcChildren"][$i], $level+1));

		return $arr_return;
	}//endof inOrder
	
	
	/*
	Retrieve sub category nodes
	*/
	function subCategories($nodeId)		 {
		/*
		This function make use of inOrder to return an array of the sub-categories (nested).
		Return structure is the same as inOrder function
		*/
		return $this->inOrder($nodeId, 1);
	}
	
	
	/*
	Retrieve IDs of all sub categories
	*/
	function subCategoryIDs($nodeId) {
		/*
		Return an array of all sub-category (nested) IDs
		NOTE: The return array will include the parent ID
		*/
		$arr_return = array();
		
		$arr_return[] = $nodeId;
		for ($i=0; $i<count($this->arr_nodes[$nodeId]["fcChildren"]); $i++)
			$arr_return = array_merge($arr_return, 
				$this->subCategoryIDs($this->arr_nodes[$nodeId]["fcChildren"][$i]));
		
		return $arr_return;
	}

	
	/*
	Retrieve sub subParentProd nodes
	*/
	function subParentProd($nodeId)		 {
		/*
		This function make use of inOrder to return an array of the sub-categories (nested).
		Return structure is the same as inOrder function
		*/
		return $this->inOrder($nodeId, 1);
	}
	
	
	/*
	Retrieve IDs of all sub categories
	*/
	function subParentProdIDs($nodeId) {
		/*
		Return an array of all sub-category (nested) IDs
		NOTE: The return array will include the parent ID
		*/
		$arr_return = array();
		
		$arr_return[] = $nodeId;
		for ($i=0; $i<count($this->arr_nodes[$nodeId]["fcChildren"]); $i++)
			$arr_return = array_merge($arr_return, 
				$this->subParentProdIDs($this->arr_nodes[$nodeId]["fcChildren"][$i]));
		
		return $arr_return;
	}
	
	
	/*
	Retrieve path of selected node from the root node
	*/
	function path($nodeId)	{
		$arr_return = array();
		
		$node = $this->arr_nodes[$nodeId];
		$arr_return[] = $node;
	
		if ($this->arr_nodes[$nodeId][$this->parentIdField] >= 0)
			return array_merge($this->path($this->arr_nodes[$nodeId][$this->parentIdField]), $arr_return);
		else
			return $arr_return; 
	}
	
	/*
	Return the path string
	*/
	function pathString($nodeId, $idField="id", $nameField="name", $showroot=0, $delim=" / ", $url="")	{
		$arrpath = $this->path($nodeId);
		$rtn = "";
		
		$last = count($arrpath)-1;
		if ($showroot==1)
			$start = 0;
		else
			$start = 1;
		for ($i=$start; $i<count($arrpath); $i++)	 {
			$rtn .= ($rtn==""? "" : $delim).
				($url=="" || $i==$last? "" : "<a href='$url".$arrpath[$i][$idField]."'>").
				$arrpath[$i][$nameField].($url=="" || $i==$last? "" : "</a>"); 
		}
		return $rtn;
	}
	
	// output to html
	public function html_checkbox( $option , $checked=array() , $configroot=NULL ) {
		

		# ROOT Config
		if ($configroot===NULL) {
			$configroot = array(
				'attr'=>array(),
				'show'=>false,
			);
		}		
		$html_attr = '';
		if (!empty($option['attr'])) {
			foreach ($option['attr'] as $key => $val) {
				$html_attr .= $key.'="'.$val.'" ';
			}
		}
		$html  = '<ul '.$html_attr.' >';

		if( $configroot['show'] ) {
			$label = $option['root_name'];
			//$rurl= array($option['url']);
			$htmlOption = array();
			$html .= '<li > '.$option['root_name'].' </li>';
		}

		# NODE CREATION
		$tree = $this->order_nodes;
		unset($tree[0]);
		$lv = 0;
		foreach( $tree as $val ) {
			$checkflag = '';
			if (in_array($val['id'],$checked)) {
				$checkflag = 'checked="true"';
			}
			
			while( $lv-- > $val['fcLevel'] ) $html .= ' </ul>'."\n\r";

			
			if( !empty($val['fcChildren']) ) {
				$html .= '<li ><input type="checkbox" id="cat'.$val['id'].'" name="'.$option['name'].'['.$val['id'].']" '.$checkflag.' /> <label for="cat'.$val['id'].'">'.$val['name'].'</label><ul>'."\n\r";
			}

			else if( empty($val['fcChildren']) ) {
				$html .= '<li ><li ><input type="checkbox" id="cat'.$val['id'].'" name="'.$option['name'].'['.$val['id'].']" '.$checkflag.' /> <label for="cat'.$val['id'].'">'.$val['name'].'</label></li>'."\n\r";
			}

			$lv=$val['fcLevel'];
		}
		
		while( $lv-- > 2 ) $html .= ' </ul>'."\n\r";
		$html = $html.'</ul>';

		return $html;
	}
	/**
	 * HTML LIST generator
	 *
	 * @param ARRAY $config key => url , attr
	 * @param string $configroot key => name , show , attr
	 * @return string HTML
	 * @author Elliot Yap
	 */
	public function html_list( $config , $configroot=NULL) {

		# ROOT Config default
		if ($configroot===NULL) {
			$configroot = array(
				'attr'=>array(),
				'show'=>false,
				'name'=>'ROOT',
			);
		}
		
		$html  = '<ul class="tree" >';
		if (!empty($config['attr'])) {
			$html  = '<ul '.$this->_implodeAttr($config['attr']).' >';
		}

		if( $configroot['show'] ) {
			$html .= '<li><a href="'.$config['url'].'">'.$configroot['name'].'</a></li>';
		}

		# NODE CREATION
		$tree = $this->order_nodes;
		unset($tree[0]);
		$lv = 0;
		foreach( $tree as $val ) {
						
			while( $lv-- > $val['fcLevel'] ) $html .= ' </ul>'."\n\r";

			$label = $val['name'];
			$rurl= array($config['url'],'id'=>$val['id'],'name'=>$val['name']);
			
			if( !empty($val['fcChildren']) ) {
				$htmlOption = array('class'=>'dir');
				$html .= '<li tid="'.$val['id'].'">'.CHtml::link($label,$rurl,$htmlOption).'<ul>'."\n\r";
			}

			else if( empty($val['fcChildren']) ) {
				$htmlOption = array();
				$html .= '<li tid="'.$val['id'].'">'.CHtml::link($label,$rurl,$htmlOption).'</li>'."\n\r";
			}

			$lv=$val['fcLevel'];
		}
		
		while( $lv-- > 2 ) $html .= ' </ul>'."\n\r";
		$html = $html.'</ul>';

		return $html;
	}
	
	public function dropDownArray() {
		$result = array();
		$tree 	= $this->order_nodes;
		foreach ($tree as $node) {
			$result[$node['id']] = str_repeat('-',$node['fcLevel']-1).' '.$node['name'];
		}
		return $result;
	}
	
	private function _implodeAttr($array) {
		$html = '';
		foreach ($array as $key => $val)
			$html .= $key.'="'.$val.'" ';
		return $html;
	}
}
?>