
<?php 
class Edit{
	public $contents0;
	public $contents1;
	public $contents2;
	public $contents3;
	public $contents4;
	public $contents5;


	public function __construct(){
		$db_user = "matsuko";
		$db_pass = "matsuko";
		$db_host = "127.0.0.1";
		$db_name = "recer";
		$db_type = "mysql";

		$dsn = "$db_type:host=$db_host;dbname=$db_name;charaset=utf8";
		try {
			$pdo = new PDO ($dsn, $db_user, $db_pass);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$pdo->beginTransaction();

			$titlAll = array();
			$textAll = array();
			$sql0 = "select * from contents";
			$sql1 = "select * from contents where category = 1";
			$sql2 = "select * from contents where category = 2";
			$sql3 = "select * from contents where category = 3";
			
			for($i = 0; $i < 4; $i++){
				$stmt = $pdo->prepare(${'sql'. $i});
		  		$stmt->execute();
		  		${'contents'. $i} = $stmt->fetchAll();
			  	$this->{'contents'. $i} = ${'contents'. $i};
		  	}

		  	if($_POST){
			  	if($_POST['editTitle']){
			        $sql_edit = "UPDATE recer.contents SET title = :editTitle, text = :editText WHERE id = :editId";
			        $stmh = $pdo->prepare($sql_edit);
			        $stmh->bindValue(':editId', $_POST['editId'], PDO::PARAM_INT);
			        $stmh->bindValue(':editTitle', $_POST['editTitle'], PDO::PARAM_STR);
			        $stmh->bindValue(':editText', $_POST['editText'], PDO::PARAM_STR);
			        $stmh->execute();
			        header("Location: ../rec");
			    } else{ 

				    	$sql_trash = "DELETE FROM contents WHERE id = :trashId";
				    	$stmi = $pdo->prepare($sql_trash);
				    	$stmi->bindValue(':trashId', $_POST['trashId'], PDO::PARAM_INT);
				    	$stmi->execute();
				        header("Location: ../rec");
				  	

			    }
			}

		    $pdo->commit();

		} catch (PDOException $e){

		 	 print "エラー : " . $e->getMessage();
		}


	}


	public function select(){
			$l;
			$html ='<div id="content">';
			for($l=0; $l<4; $l++){
				$html .= '<div id="category'. $l. '" class="box';
				if($l == 0){ $html .= ' activeBox'; }
				$html .= '"><a href="#" class="category'. $l.'"></a>';

				$m;
				for ($m=0; $m <count($this->{'contents'. $l}); $m++) {
					if($this->{'contents'. $l}[$m]['category'] == NULL)
					continue;

				// タイトル
				$html .= '<a href="#" id="title'.  $l. '_'. $this->{'contents'. $l}[$m]['id'].
				'" data-id="'. $l. '_'. $this->{'contents'. $l}[$m]['id'].
				'" class="title">'. $this->{'contents'. $l}[$m]['title'].
				'</a>';

				// 編集フォーム
				$html .= 
				'<form action="'. $_SERVER["PHP_SELF"]. '" method="post"
				 class="hiddenform" id="form'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '">
				<input type="hidden" value="'. $this->{'contents'. $l}[$m]['id'].
				'" name="editId">
				<input type="text" value="'. $this->{'contents'. $l}[$m]['title'].
				'" name="editTitle">
				<textarea name="editText" cols="30" rows="5" name="editText">'. 
				$this->{'contents'. $l}[$m]['text']. '</textarea>
				<input type="submit" value="編集">
				</form>';

				// ✕ボタン(編集フォーム)
				$html .=
				'<a href="#" id="editDust'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '" 
				data-id="title'. $l. '_'.  $this->{'contents'. $l}[$m]['id']. '" 
				data-form="form'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '" 
				class="fa fa-times editDustHide" aria-hidden="true"></a>';

				// 編集ボタン、 fontawesomeより
				$html .= '
				<a href="#" class="fa fa-pencil-square-o edit" aria-hidden="true" 
				data-id="title'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '" 
				data-form="form'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '" 
				data-editdust="editDust'. $l. '_'. $this->{'contents'. $l}[$m]['id']. '"></a>';

				// ゴミ箱ボタン
				$html .= '
				<a href="#" id="trashlink_'. $this->{'contents'. $l}[$m]['id']. '" 
				class="fa fa-trash-o trash trashlink" aria-hidden="true" 
				data-id=trashForm_'. $this->{'contents'. $l}[$m]['id']. '></a>					
				<form  name="trashForm_'. $this->{'contents'. $l}[$m]['id']. '" 
				action="'. $_SERVER["PHP_SELF"]. '" method="post" class="trashForm" 
				id="trashForm_'. $this->{'contents'. $l}[$m]['id']. '">
				<input type="hidden" name="trashId" 
				value="'. $this->{'contents'. $l}[$m]['id']. '"></form>';

				// テキスト
				$html  .= '
				<div id="'. $l. '_'. $this->{'contents'. $l}[$m]['id']. 
				'" class="text">'.
				$this->{'contents'. $l}[$m]['text'].
				'</div>';
				
			}
			$html .= '</div>';
				
			}
			$html .= '</div>';
			echo $html;			


			}
		
	}



?>
