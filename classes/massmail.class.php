<?php 

class massmail extends dbClass
{
		//constructor
		public $field_types = array();
		function massmail()
		{
			$this->dbClass();
		} 
		
		///////  Connect Save  //////
	
		
		function CreateAccountMailChimp($arg=array()){
			return $this->insert( 'c_mail_chimp_setting', $arg, $format = null );
		}
		
		function AddUserMailChimp($arg=array()){
			return $this->insert( 'c_mail_chimp_users', $arg, $format = null );
			}
			
		function AddchimpSegment($arg=array()){
			return $this->insert( 'c_mail_chimp_segment', $arg, $format = null );
			}
			
		function AddchimpCampaign($arg=array()){
			return $this->insert( 'c_mail_chimp_campaigns', $arg, $format = null );
			}
		
		function GetMailchimSetting(){
	           $sql = "Select * FROM c_mail_chimp_setting";
			   return $this->query($sql);
        }
		
		function GetMailchimUser(){
			   $sql = "Select * FROM c_mail_chimp_users";
			   return $this->query($sql);
		}
		
		function GetchimpSegment(){
			   $sql = "Select * FROM c_mail_chimp_segment";
			   return $this->query($sql);
		}
		function GetchimpCampaign(){
			   $sql = "Select * FROM c_mail_chimp_campaigns";
			   return $this->query($sql);
		}
		
		function deleteMailchimUser($userId){
			
			$sql ="delete from c_mail_chimp_users where id='".$userId."'";
		
			return $this->query($sql);
			
		}
      
      function deleteMailchimSegment($Id){
			
			$sql ="delete from c_mail_chimp_segment where id='".$Id."'";
		
			return $this->query($sql);
			
		}	
		
		function deleteMailchimCampaign($Id){
			
			$sql ="delete from c_mail_chimp_campaigns where id='".$Id."'";
		
			return $this->query($sql);
			
		}
		
		function UpdateStatusMailchimCampaign($Id){
			
			$sql ="UPDATE c_mail_chimp_campaigns SET status='send' where id='".$Id."'";
		
			return $this->query($sql);
			
		}	
		
		function getSocialUserConnect($Socialtype='twitter',$fields=array()){
			$selectfield='*';
			if(!empty($fields))
			$selectfield=implode(', ',$fields);
			$sql="Select $selectfield FROM c_socialuserconnect WHERE social_type='".$Socialtype." '";
			return $this->query($sql);
		}
		
		//********** Prepare Query ******************/
		public function prepare( $query, $args ) {
		if ( is_null( $query ) )
			return;

		// This is not meant to be foolproof -- but it will catch obviously incorrect usage.
		if ( strpos( $query, '%' ) === false ) {
			_doing_it_wrong( 'wpdb::prepare', sprintf( __( 'The query argument of %s must have a placeholder.' ), 'wpdb::prepare()' ), '3.9' );
		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace( "'%s'", '%s', $query ); // in case someone mistakenly already singlequoted it
		$query = str_replace( '"%s"', '%s', $query ); // doublequote unquoting
		$query = preg_replace( '|(?<!%)%f|' , '%F', $query ); // Force floats to be locale unaware
		$query = preg_replace( '|(?<!%)%s|', "'%s'", $query ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) );
		return @vsprintf( $query, $args );
	}
	public function insert( $table, $data, $format = null ) {
		return $this->_insert_replace_helper( $table, $data, $format, 'INSERT' );
	}
	function _insert_replace_helper( $table, $data, $format = null, $type = 'INSERT' ) {
		if ( ! in_array( strtoupper( $type ), array( 'REPLACE', 'INSERT' ) ) )
			return false;
		$this->insert_id = 0;
		$formats = $format = (array) $format;
		$fields = array_keys( $data );
		$formatted_fields = array();
		foreach ( $fields as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = $form;
		}
		 $sql = "{$type} INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
		$this->prepare( $sql, $data );
		return $this->query( $this->prepare( $sql, $data ) );
	}
	
	public function update( $table, $data, $where, $format = null, $where_format = null ) {
		if ( ! is_array( $data ) || ! is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		foreach ( (array) array_keys( $data ) as $field ) {
			if ( !empty( $format ) )
				$form = ( $form = array_shift( $formats ) ) ? $form : $format[0];
			elseif ( isset($this->field_types[$field]) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";
		}

		$where_formats = $where_format = (array) $where_format;
		foreach ( (array) array_keys( $where ) as $field ) {
			if ( !empty( $where_format ) )
				$form = ( $form = array_shift( $where_formats ) ) ? $form : $where_format[0];
			elseif ( isset( $this->field_types[$field] ) )
				$form = $this->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}

		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );
		return $this->query( $this->prepare( $sql, array_merge( array_values( $data ), array_values( $where ) ) ) );
	}
		
}

?>
