
 <?php
//Controller
     class NewsController extends Zend_Controller_Action 
     {
         /**
          * News index
          */
         public function indexAction() 
         {
             $modelNews = new News();
             $news = $modelNews->getNews();
			 
			 // Defining vars for View
             $this->view->news = $news;
         }

         public function viewAction() 
         {
             // Here we get user parameter
             $newsId = $this->_getParam('newsId');
             
			 
             $modelNews = new News();

             // Details about news item
             $news = $modelNews->getNews($newsId);

             // Defining vars for View
             $this->view->news = $news;
         }
		 
		 //The following is likewise as in news index section:
		 function addAction()
         {
             echo "<p>Add news item IndexController::addAction()</p>";
         }

         function editAction()
         {
             echo "<p>Edit news item IndexController::editAction()</p>";
         }

         function deleteAction()
         {
             echo "<p>Remove news item IndexController::deleteAction()</p>";
         }
		 
		 
     }


<?php

//Registration database parameters in Bootstrap.php
// columns:  id, date_timestamp, update_timestamp, news_header, news_header2, news_body, news_publushed

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
...
public function setDbAdapter() 
         {
             $db = Zend_Db::factory($this->_config->db);
             Zend_Db_Table_Abstract::setDefaultAdapter($db);
             Zend_Registry::set('zf1_stud_news', $db);
         }
...		 
	 
}	 

<?php
//Model

    class News extends Zend_Db_Table_Abstract
    {
        // Table name
        protected $_name = 'news';
        
		
		//One news item or more than one
		//@param int $id_news news id
        //@return array
	
		
        public function getNews($id_news = null)
        {

             $select = $this->getAdapter()->select()
                ->from($this->_name)from($this->_name,array('id','news_header', 'news_header2', 'news_body'));
 
            if (!is_null($id_news)) {
                
                $select->where("id = ?",$id_news); 
                $stmt = $this->getAdapter()->query($select);
                $result = $stmt->fetch(Zend_Db::FETCH_OBJ);
            }
            else {

                $stmt = $this->getAdapter()->query($select);
                $result = $stmt->fetchAll(Zend_Db::FETCH_OBJ);        
            }

            return $result;

        }

    }
	

//View	
        <table>
		<tr>
		<th>
		<td>Заголовок</td>
		<td>Анонс</td>
		<td>&nbsp</td>
		<td>&nbsp</td>
		<td></td>
		</th>
		</tr>
		
		//Looping through the table
        <?php foreach ($this->news as $news): ?>
		<tr>
		 <td><?php echo $this->escape( $news->news_header); ?> </td >
		 <td><?php echo $this->escape( $news->news_header2); ?> </td >
         <td><a href =" <?php echo $this->url( array ( 'controller' => 'index' , 'action' => 'edit' , 'id' => $news->id)); ?> "> Редактировать </a></td>
		 <td><a href =" <?php echo $this->url( array ( 'controller' => 'index' , 'action' => 'remove' , 'id' => $news->id)); ?> "> Удалить </a></td>
        </tr>
        <?php endforeach; ?>
		</table>
		


