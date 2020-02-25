  <!--编辑的模态框-->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title " id="exampleModalLabel">编辑用户</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body pl-5">
          <form id="editForm">
            <div id="editImformation">
              <div>
                <label for="username">用户名：</label><br>
                <input type="text" class="input controltName form-controlt" id="editUsername" name="username" disabled placeholder=" 4-16字符，允许中英文(中文算2字符）、数字">
              </div>
              <div class="radio">
                <label>角色:</label><br>
                <div class="editRoleRadio float-left mr-2">
                  <input type="radio" id="administator" value="admin" name="role" checked>
                  <label for="administator">管理员</label>
                </div>
                <div class="editRoleRadio mr-2" id="editMemberRadio">
                  <input type="radio" id="member" value="member" name="role">
                  <label for="member">成员</label>
                </div>
              </div>
              <div>
                <label for="trueName">真实姓名: </label><br>
                <input type="text" class="input" id="editTrueName" name="trueName">
              </div>
              <div>
                <label for="email">电子邮箱: </label><br>
                <input type="email" class="input" id="editEmail" name="email">
              </div>
              <div>
                <label for="age">年龄: </label><br>
                <input type="text" class="input" id="editAge" name="age">
              </div>
              <div class="radio">
                <label for="job">职业: </label><br>
                <div class="editJobRadio float-left mr-2">
                  <input type="radio" id="student" value="student" name="editJob" checked>
                  <label for="student">学生</label>
                </div>
                <div class="editJobRadio">
                  <input type="radio" id="worker" value="worker" name="editJob">
                  <label for="worker">上班族</label>
                </div>
              </div>
              <div>
                <label for="schoolOrCompany">学校/公司: </label><br>
                <input type="text" class="input" id="editSchoolOrCompany" name="schoolOrCompany">
              </div>
              <div class="checkbox">
                <label for="hobby">兴趣爱好: </label><br>
                <input type="checkbox" value="绘画" name="hobby">
                <label class="editHobby">绘画</label>
                <input type="checkbox" value="音乐" name="hobby">
                <label class="editHobby">音乐</label>
                <input type="checkbox" value="粘土" name="hobby">
                <label class="editHobby">粘土</label>
                <input type="checkbox" value="学习" name="hobby">
                <label class="editHobby">学习</label>
                <input type="checkbox" value="摸鱼" name="hobby">
                <label class="editHobby">摸鱼</label>
                <input type="checkbox" value="划水" name="hobby">
                <label class="editHobby">划水</label>
              </div>
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
          <button type="submit" id="edit" class="btn btn-primary" value="save">保存</button>
        </div>
      </div>
    </div>
  </div>