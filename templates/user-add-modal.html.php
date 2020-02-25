 <!-- 新增的模态框 -->
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">

       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">添加用户</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>

       <div class="modal-body pl-5">
         <form id="addForm">
           <div id="imformation">
             <div>
               <label for="username">用户名：</label><br>
               <input type="text" class="input" id="username" name="username" placeholder=" 4-16字符，允许中英文(中文算2字符）、数字">
             </div>
             <div>
               <label for="password">密码: </label><br>
               <input type="password" class="input" id="password" name="password" placeholder=" 6-18字符，允许英文、数字、符号">
             </div>
             <div>
               <label for="confirm-password">确认密码: </label><br>
               <input type="password" class="input" id="confirm-password" name="confirm-password" placeholder=" 请重复密码">
             </div>
             <div>
               <label for="trueName">真实姓名: </label><br>
               <input type="text" class="input" id="trueName" name="trueName">
             </div>
             <div>
               <label for="email">电子邮箱: </label><br>
               <input type="email" class="input" id="email" name="email">
             </div>
             <div>
               <label for="age">年龄: </label><br>
               <input type="text" class="input" id="age" name="age">
             </div>
             <div class="radio">
               <label for="job">职业: </label><br>
               <div class="addJob float-left">
                 <input type="radio" value="student" name="job" checked>
                 <label for="addStudent">学生</label>
               </div>
               <div class="addJob">
                 <input type="radio" value="worker" name="job">
                 <label for="addWorker">上班族</label>
               </div>
             </div>
             <div>
               <label for="schoolOrCompany">学校: </label><br>
               <input type="text" class="input" id="schoolOrCompany" name="schoolOrCompany">
             </div>
             <div class="checkbox">
               <label for="newhobby">兴趣爱好: </label><br>
               <input type="checkbox" value="绘画" name="newhobby">
               <label class="addHobby">绘画</label>
               <input type="checkbox" value="音乐" name="newhobby">
               <label class="addHobby">音乐</label>
               <input type="checkbox" value="粘土" name="newhobby">
               <label class="addHobby">粘土</label>
               <input type="checkbox" value="学习" name="newhobby">
               <label class="addHobby">学习</label>
               <input type="checkbox" value="摸鱼" name="newhobby">
               <label class="addHobby">摸鱼</label>
               <input type="checkbox" value="划水" name="newhobby">
               <label class="addHobby">划水</label>
             </div>
           </div>
         </form>
       </div>

       <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
         <button type="submit" id="add" class="btn btn-primary" value="add">添加</button>
       </div>
     </div>
   </div>
 </div>