  <!--显示详情的模态框-->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">用户详情</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body pl-5">
          <div id="showImformation">
            <p>
              <label class="showLeft">用户名:</label>
              <label id="showUsername"></label>
            </p>
            <P>
              <label class="showLeft">角色:</label>
              <label id="showRole"></label>
            </P>
            <p>
              <label class="showLeft">真实姓名: </label>
              <label id="showTrueName"></label>
            </p>
            <p>
              <label class="showLeft">电子邮箱: </label>
              <label id="showEmail"></label>
            </p>
            <p>
              <label class="showLeft">年龄: </label>
              <label id="showAge"></label>
            </p>
            <p>
              <label class="showLeft">职业: </label>
              <label id="showJob"></label>
            </p>
            <p>
              <label class="showLeft">公司/学校: </label>
              <label id="showSchoolOrJob"></label>
            </p>
            <p>
              <label class="showLeft">兴趣爱好: </label>
              <label id="showHobby"></label>
            </p>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
        </div>
      </div>
    </div>
  </div>