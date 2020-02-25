<?php require 'common/header.html.php'; ?>

<?php
if ($_SESSION['role'] == "admin") {
  require 'user-add-modal.html.php';
  require 'user-edit-modal.html.php';
}
?>

<?php require 'user-show-modal.html.php' ?>

<!--确认删除的模态框-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLabel">警告</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body pl-5">
        确定要删除该条记录吗？
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
        <button type="submit" id="delete" class="btn btn-primary" value="yes">确定</button>
      </div>
    </div>
  </div>
</div>

<!--标签页和搜索-->
<div class="search text-bottom pt-1">
  <ul class="nav nav-tabs float-left" id="nav-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link border-secondary jobKey <?php if ($util->getQuery('jobKey') != 'student'&&$util->getQuery('jobKey')!='worker') echo "active"; ?>" href="#" data-toggle="tab" role="tab" aria-selected='<?php if($util->getQuery('jobKey')!=("student"||"worker")) echo true; ?>'>全部</a>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-body border-secondary jobKey <?php if ($util->getQuery('jobKey') == 'student') echo "active"; ?>" href="#" data-toggle="tab" role="tab" aria-selected='<?php if($util->getQuery('jobKey') == "student")echo true; ?>'>学生</a>
    </li>
    <li class="nav-item">
      <a class="nav-link bg-body border-secondary jobKey <?php if ($util->getQuery('jobKey') == 'worker') echo "active"; ?>" href="#" data-toggle="tab" role="tab" aria-selected='<?php if($util->getQuery('jobKey') == "worker") echo true; ?>'>上班族</a>
    </li>
  </ul>

  <?php if ($_SESSION["role"] == "admin") { ?>
    <button class="chooseAdd btn btn-dark float-left ml-3 border-secondary" data-placement="top" title="添加用户" data-toggle="modal" data-backdrop='static' data-target="#exampleModal">+</button>
  <?php } ?>
  <div class="pb-1 text-right">

    <div class="btn-group">

      <button type="button" id="selectedKey" class="btn-key btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php $showSelect = ["用户名",'角色', "姓名", "邮箱", "学校/公司", "兴趣爱好"];
	        $trueSelect = ["username", "role", "truename", "email", "schoolOrCompany", "hobby"];
         if($util->getQuery('keyName'))
         {
           echo $showSelect[array_search($util->getQuery('keyName'),$trueSelect)];
         }else{
           echo "用户名";
          } ?>
      </button>

      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">用户名</a>
        <a class="dropdown-item" href="#">角色</a>
        <a class="dropdown-item" href="#">姓名</a>
        <a class="dropdown-item" href="#">邮箱</a>
        <a class="dropdown-item" href="#">学校/公司</a>
        <a class="dropdown-item" href="#">兴趣爱好</a>
      </div>

    </div>
    <input class="keyWord rounded-pill bg-light" id="searchKey" type="text" placeholder="请输入关键字" value="<?php 
    if($util->getQuery('keyWord'))
    {
      if($util->getQuery('keyWord')=='admin')
      {
        echo '管理员';
      }
      elseif($util->getQuery('keyWord')=='member')
      {
        echo '成员';
      }else echo $util->getQuery('keyWord');
    } ?>">
    <button class="btnSearch btn-outline-dark rounded-pill" id="search" data-toggle="tooltip" data-placement="top" title="“咻”一下搜索">咻</button>
  </div>
</div>

<div id="errorMessageDiv" class="alert alert-primary alert-dismissible fade show" role="alert">
  <label class="showErrorMessage"></label>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<?php 
$flashMessage = $util->getFlashMessage();
 if($flashMessage){ ?>
  <div id="flashMessage" class="alert alert-<?php echo $flashMessage['type']; ?> alert-dismissible fade show" role="alert">
  <?php echo $flashMessage['message']; ?>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php }?>

<!--表格-->
<div class="table mt-3">
  <div class="container-fluid border border-secondary">
    <div class='row bg-secondary text-light'>
      <div class='col col-md-1'>ID</div>
      <div class='col col-md-1'>用户名</div>
      <div class='col col-md-1'>角色</div>
      <div class='col col-md-1'>姓名</div>
      <div class='col col-md-3'>邮箱</div>
      <div class='col col-md-1'>职业</div>
      <div class='col col-md-2'>学校/公司</div>
      <div class='col col-md-2'>操作</div>
    </div>
    <?php
    foreach ($users as $user) {
      $user["role"]=='member'?$user['role']='成员':$user['role']='管理员';
      $user["job"]=='student'?$user['job']='学生':$user['job']='上班族';
      if (count($user) > 1) {
        $showLine = "<div class='row align-middle'>" .
          "<div class='col col-md-1'>" . $user["id"] . "</div>" .
          "<div class='col col-md-1'>" . $user["username"] . "</div>" .
          "<div class='col col-md-1'>" . $user["role"] . "</div>" .
          "<div class='col col-md-1'>" . $user["truename"] . "</div>" .
          "<div class='col col-md-3'>" . $user["email"] . "</div>" .
          "<div class='col col-md-1'>" . $user["job"] . "</div>" .
          "<div class='col col-md-2'>" . $user["schoolOrCompany"] . "</div>" .
          "<div class='col col-md-2 p-1'>" .
          "<button class='btn detail btn-primary ml-2' data-toggle='modal' data-target='#detailModal' value='" . $user["id"] . "'>详情</button>";
        if ($_SESSION["role"] == "admin"&& $_SESSION["id"] != $user["id"]) {
          $showLine .=
            "<button class='btn edit btn-primary ml-2' data-toggle='modal' data-target='#editModal' value='" . $user["id"] . "'>编辑</button>" .
            "<button class='btn delete btn-primary ml-2' data-toggle='modal' data-target='#deleteModal' value='" . $user["id"] . "'>删除</button>";
        }
        if ($_SESSION["id"] == $user["id"]&&$_SESSION['role']=='admin') {
          $showLine .=
            "<button class='btn edit btn-primary ml-2' data-toggle='modal' data-target='#editModal' value='" . $user["id"] . "'>编辑</button>";
        }
        $showLine .= "</div></div>";
        echo $showLine;
      }
    }
    ?>
  </div>

</div>
<!--页码-->
<?php if ($page > 0) {
  $params = $_SERVER["QUERY_STRING"];
  ?>
  <nav aria-label="Page navigation example" class="page">
    <ul class="pagination">
      <?php if($pages['prev']=='enable'){ ?>
      <li class="page-item">
        <a class="page-link" href="index.php?<?php $prePage = $page - 1;
            if (empty($params)) {
                $preParams = $params . "page=" . $prePage;
            }
            strpos($params, "page=") ? $preParams = substr_replace($params, "page=" . $prePage, strpos($params, "page=")) : $preParams = $params . "&page=" . $prePage;
            echo $preParams ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;上一页</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <?php }
      foreach($pages['pages'] as $getPage)
      {
        if($getPage=='...'){
          echo '&nbsp;...&nbsp;';
        }else{?>
        <li class="page-item">
          <a class="page-link <?php if($getPage==$page) echo "bg-secondary text-light" ?>" href="index.php?<?php if (empty($params)) $nowParams = $params . "page=" . $getPage;
            strpos($params, "page=") ? $nowParams = substr_replace($params, "page=" . $getPage, strpos($params, "page=")) : $nowParams = $params . "&page=" . $getPage;
            echo $nowParams ?>"><?php echo $getPage ?>
          </a>
        </li>
      <?php }
      } ?>

    <?php if($pages['next']=='enable'){ ?>
      <li class="page-item">
        <a class="page-link" href="index.php?<?php $nextPage = $page + 1;
          if (empty($params)) {
              $nextParams = $params . "page=" . $nextPage;
          }
          strpos($params, "page=") ? $nextParams = substr_replace($params, "page=" . $nextPage, strpos($params, "page=")) : $nextParams = $params . "&page=" . $nextPage;
          echo $nextParams ?>" aria-label="Next">
          <span aria-hidden="true">下一页&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    <?php } ?>
    </ul>
  </nav>
<?php } elseif ($page < 0) { ?>
  <p class="text-danger text-center font-weight-bold">没有查询到记录！</p>
<?php } ?>

<?php require 'common/footer.html.php'; ?>