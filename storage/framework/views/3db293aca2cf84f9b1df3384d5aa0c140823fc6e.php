
<style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td{
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #eae9e9;}
</style>

<table width="100%" border="0" id="customers" cellspacing="0" cellpadding="0">
	  <tbody>
		<tr>
		  <td colspan="2"><p>Dear <strong> Admin,</strong></p></td>
		</tr>
		<tr>
		  <td colspan="2"><p>A user has submitted a essay question in a test with following details.</p></td>
		</tr>
		<tr>
		  <td valign="middle" style="line-height:23px;"><p>User Name</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($username); ?></p></td>
		</tr>
<tr>
		  <td valign="middle" style="line-height:23px;"><p>User Login Id</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($user_login); ?></p></td>
		</tr>
<tr>
		  <td valign="middle" style="line-height:23px;"><p>Section Name</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($section); ?></p></td>
		</tr>
<tr>
		  <td valign="middle" style="line-height:23px;"><p>Test</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($tests); ?></p></td>
		</tr>
<tr>
		  <td valign="middle" style="line-height:23px;"><p>Question</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($question); ?></p></td>
		</tr>
<tr>
		  <td valign="middle" style="line-height:23px;"><p>Essay</p></td>
		  <td valign="middle" style="line-height:23px;"><p><?php echo e($user_answer); ?></p></td>
		</tr>
	  </tbody>
</table>




<?php /**PATH C:\xampp\htdocs\training\admin\resources\views/emails/essay_mail.blade.php ENDPATH**/ ?>