
 <?php
//Controller
     class NewsController extends Zend_Controller_Action 
     {
         /**
          * ������ ��������
          */
         public function indexAction() 
         {
             $modelNews = new News();
             $news = $modelNews->getNews();
			 
			 // ����������� ���������� ��� View
             $this->view->news = $news;
         }

         public function viewAction() 
         {
             // ��������� ��������� �� ������������
             $newsId = $this->_getParam('newsId');
             
			 //�������� ������� ��. Model
             $modelNews = new News();

             // ���������� � �������
             $news = $modelNews->getNews($newsId);

             // ����������� ���������� ��� View
             $this->view->news = $news;
         }
		 
		 //����� ���������� ��� ��� ������ ��������
		 function addAction()
         {
             echo "<p>�������� ������� IndexController::addAction()</p>";
         }

         function editAction()
         {
             echo "<p>������������� ������� IndexController::editAction()</p>";
         }

         function deleteAction()
         {
             echo "<p>������� ������� IndexController::deleteAction()</p>";
         }
		 
		 
     }


<?php
//����������� ���������� ���������� � ����� ������ �  Bootstrap.php
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
        // ��� �������
        protected $_name = 'news';
        
		
		//��� ������� ��� ����
		/**
         *
         * @param int $id_news ������������� �������
         * @return array
         */
		
		
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
<ul>
        <?php foreach ($this->news as $news): ?>
           <li><a href = "<?php echo $this->url(array('id_news' => $news->id),'news'); ?>">
           <?php echo $news->news_header; ?></a></li>

        <?php endforeach; ?>
</ul>	

