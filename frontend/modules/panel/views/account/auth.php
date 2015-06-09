<?php
echo '<strong>Welcome To TB_StroreHelper! </strong>';
header("location: https://oauth.tbsandbox.com/authorize?response_type=code&client_id={$appid}&redirect_uri={$url}&state=1212&view=web");
       
