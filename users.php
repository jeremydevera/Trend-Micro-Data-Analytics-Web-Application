<?php include 'auth.php' ?>
<?php include 'base.php' ?>

<?php
    $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
    $user = mysqli_query($conn, $user);
    $user = mysqli_fetch_assoc($user);
    $samples = "SELECT id FROM charles_table_primary WHERE tester ='" . $_SESSION['username'] . "'";
    $samples = mysqli_query($conn, $samples);
    $samples = mysqli_num_rows($samples);
?>

<?php startblock('extrastyle') ?>
    <script src="static/js/selections.js"></script>
    <title> CI - Users </title>
    <style>
        html {
            /* background-color: rgba(255, 210, 210, 0.692); */
            background-color: rgba(182, 225, 253, 0.3);
        }
        body {
            /* background-color: rgba(122, 47, 47, 0); */
            background-color: rgba(17, 58, 97, 0);
            padding: 10px;
        }
    </style>

    <script>
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
            $('.proceed_username').click(function () {
                $('#modal_confirm').modal({autofocus: true,}).modal('show');
            });
            $('.cancel_button').click(function () {
                $('.ui.modal').modal('hide');
            });
            $('#change_password').click(function () {
                $('#modal_password').modal({autofocus: true,}).modal('show');
            });
        });
    </script>
<?php endblock() ?>

<?php startblock('body') ?>
    <div class="ui form">
        <div class="two fields">
            <div class="ten wide field">
                <div style="padding: 0px; height: 80%;" class="ui segments container">
                    <div style="padding: 15px; margin: 0px;" class="ui segment container">
                        <img class="ui tiny avatar image" src="static/pictures/icon.png">
                        <span style="font-size: 170%; margin-left: 20px;">Username : &nbsp&nbsp<?php echo $_SESSION['username']?></span>
                        <!-- <div class="ui divider"></div> -->
                    </div>
                    <div style="padding: 25px; margin: 0px; height: 100%;" class="ui segment container">
                        <div class="ui dividing header">
                            <h3>Account Details</h3>
                        </div>
                        <div style="text-align: center;">
                            <table class="ui table" style="width: calc(100% - 30px); height 50%; margin-left: 15px;">
                                <thead>
                                    <tr>
                                        <td style="width: 50%; padding-left:2em">Username :</td>
                                        <td style="padding-left:2em; width: 30%;">
                                            <?php echo $_SESSION['username']?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a class="ui label" onclick="update_username('form_change_username')">
                                                Change
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:2em">Password :</td>
                                        <td>
                                            <div class="ui input">
                                                <input type="password" value="<?php echo $user['password'] ?>" disabled>
                                            </div>
                                        </td>
                                        <td style="text-align: right;">
                                            <a class="ui label" id="change_password">
                                                Change
                                            </a>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="ui dividing header">
                            <h3>User Activity</h3>
                        </div>
                        <div style="text-align: center; height: calc(100% - 210px); overflow-y: scroll;">
                            <table class="ui table" style="width: calc(100% - 30px); margin-left: 15px;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width: 25%;">Date Sourced</th>
                                        <th style="text-align: center; width: 25%;">Date Tested</th>
                                        <th style="text-align: center; width: 50%;">SHA-1</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $samples = "SELECT * FROM charles_table_primary WHERE tester ='" . $_SESSION['username'] . "' ORDER by id desc";
                                        $samples = mysqli_query($conn, $samples);
                                        while($row = mysqli_fetch_array($samples)) { ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $row['date_sourced'] ?></td>
                                                <td style="text-align: center;"><?php echo $row['date_tested'] ?></td>
                                                <td style="text-align: center;"><?php echo $row['sha1'] ?></td>
                                            </tr>
                                        <?php }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr><th colspan="3">
                                        <?php
                                            $samples = "SELECT id FROM charles_table_primary WHERE tester ='" . $_SESSION['username'] . "'";
                                            $samples = mysqli_query($conn, $samples);
                                            $samples = mysqli_num_rows($samples)
                                        ?>
                                        Total samples tested : &nbsp&nbsp<?php echo $samples ?>
                                    </th></tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="six wide field">
                <div style="padding: 0px; height: 80%;" class="ui segments container">
                    <div style="padding: 25px; margin: 0px; text-align: center; vertical-align: middle; height: 110px;" class="ui segment container">
                        <i class="users icon" style="font-size: 170%; margin-top: 20px;"></i>
                        <span style="font-size: 170%; margin-left: 20px;">ALL ACCOUNTS</span>
                    </div>
                    <div style="padding: 25px; margin: 0px; height: 100%;" class="ui segment container">
                        <div class="column">
                            <b style="font-size: 18px; color: black;">All Accounts Details</b>
                            <a style="float: right; margin-top: -10px;" class="ui mini green button" onclick="create_acct()">
                                <i class="plus icon"></i> CREATE
                            </a>
                        </div>
                        <div style="margin-top: 6px;" class="ui divider"></div>
                        <div style="text-align: center; height: calc(100% - 30px); overflow-y: scroll;">
                            <table class="ui table" style="width: calc(100% - 30px); margin-left: 15px;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th style="text-align: center;">Username</th>
                                        <th style="text-align: center;">Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $users = " SELECT * FROM charles_table_users ";
                                        $users = mysqli_query($conn, $users);
                                        while($row = mysqli_fetch_array($users)) {
                                            if($row['username'] != $_SESSION['username']) {?>
                                                <tr>
                                                    <td style="width: 30%;">
                                                        <div class="ui dropdown item mini basic button">
                                                            Options <i class="dropdown icon"></i>
                                                            <div class="menu">
                                                                <?php $sid = $row['id']; $u = $row['username']; ?>
                                                                <a style="color: black;" class="item" onclick="update_acct('<?php echo $u ?>')">Update</a>
                                                                <a style="color: black;" class="item" onclick="delete_acct('<?php echo $sid ?>', '<?php echo $u ?>', 'open')">Delete</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $row['username'] ?></td>
                                                    <td><input type="password" value="<?php echo $row['password'] ?>" disabled></td>
                                                </tr>
                                            <?php }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui mini modal" id="modal_username">
        <div class="header" style="text-align: center;">
            Update Username : &nbsp&nbsp<?php echo $_SESSION['username']?>
        </div>
        <div class="content">
            <form class="ui form" id="form_change_username" method="post" action="users_update.php">
                <input type="hidden" name="update_user" value="<?php echo $_SESSION['username'] ?>">
                <input type="hidden" name="update_type" value="update">
                <div style="text-align: center;" class="field">
                    <div class="ui labeled input">
                        <div class="ui grey label">New Username : </div>
                        <input type="text" name="new_username" id="new_username" value="<?php echo $_SESSION['username']?>" required>
                    </div>                        
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            <button class="ui button proceed_username" id="proceed_butt">
                Proceed&nbsp <i class="arrow right icon"></i>
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_confirm">
        <i class="close icon"></i>
        <div class="header" style="text-align: center;">Confirm Update</div>
        <div class="content">
            <div class="ui form">
                <div style="text-align: center;" class="field">
                    <div class="ui labeled input">
                        <div class="ui grey label">Your Password : </div>
                        <input type="password" name="password" id="change_username_password" placeholder="Password" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui button" id="back_confirm" onclick="$('#modal_accounts').modal('show')">
                <i class="arrow left icon"></i> &nbspBack
            </button>
            <button class="ui blue button" id="submit_updateform" onclick="">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_password">
        <i class="close icon"></i>
        <div class="header" style="text-align: center;">
            Update Password
        </div>
        <div class="content">
            <form class="ui form" id="form_change_password" method="post" action="users_update.php">
                <input type="hidden" name="update_user" value="<?php echo $_SESSION['username'] ?>">
                <input type="hidden" name="update_type" value="password">
                <div style="text-align: center;" class="field">
                    <label>Current Password : </label>
                    <input type="password" class="pass_inputs" name="current_password" id="current_password" placeholder="Current Password" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>New Password : </label>
                    <input type="password" class="pass_inputs" name="new_password" id="new_password" placeholder="New Password" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>Confirm Password : </label>
                    <input type="password" class="pass_inputs" name="conf_password" id="conf_password" placeholder="Confirm Password" required>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            <button class="ui blue button" id="changepass_submit" onclick="update_pass()">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_accounts">
        <div class="header" id="modalaccts_header" style="text-align: center;"></div>
        <div class="content">
            <form class="ui form" id="form_update_account" method="post" action="users_update.php">
                <input type="hidden" name="update_user" id="update_user" value="">
                <input type="hidden" name="update_type" value="account">
                <div style="text-align: center;" class="field">
                    <label>Username : </label>
                    <input type="text" class="acct_update" name="acct_username" id="acct_username" placeholder="New Username" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>New Password : </label>
                    <input type="password" class="acct_update" name="new_password" id="acct_new" placeholder="New Password" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>Confirm Password : </label>
                    <input type="password" class="acct_update" name="conf_password" id="acct_conf" placeholder="Confirm Password" required>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            
            <button class="ui button" id="acctupdate_submit" onclick="check_match('accts')">
                Proceed&nbsp <i class="arrow right icon"></i>
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_create">
        <div class="header" id="modalcreate_header" style="text-align: center;">Create New Account</div>
        <div class="content">
            <form class="ui form" id="form_create" method="post" action="users_create.php">
                <div style="text-align: center;" class="field">
                    <label>Username : </label>
                    <input type="text" class="create_inputs" name="create_username" id="create_username" placeholder="New Username" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>Password : </label>
                    <input type="password" class="create_inputs" name="create_password" id="create_password" placeholder="New Password" required>
                </div>
                <div style="text-align: center;" class="field">
                    <label>Confirm Password : </label>
                    <input type="password" class="create_inputs" name="create_conf" id="create_conf" placeholder="Confirm Password" required>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            
            <button class="ui button" id="createinputs_proceed" onclick="check_match('create')">
                Proceed&nbsp <i class="arrow right icon"></i>
            </button>
        </div>
    </div>
    <div class="ui mini modal" id="modal_delete">
        <i class="close icon"></i>
        <div class="header" id="delete_header" style="text-align: center;"></div>
        <div class="content">
            <form class="ui form" id="form_delete" method="post" action="users_delete.php">
                <input type="hidden" id="id_delete" name="id_delete" value="">
                <div style="text-align: center;" class="field">
                    <div class="ui labeled input">
                        <div class="ui grey label">Your Password : </div>
                        <input type="password" name="password" id="delete_password" placeholder="Password" required>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui red button cancel_button">
                <i class="thumbs down outline icon"></i> Cancel
            </button>
            <button class="ui blue button" id="del_acctbutt" onclick="delete_acct()">
                <i class="thumbs up outline icon"></i> Submit
            </button>
        </div>
    </div>
<?php endblock() ?>

<?php startblock('extrascripts') ?>
    <script>
        var acct_delinputs = document.getElementById("delete_password");
            acct_delinputs.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('del_acctbutt').click();
                }
        });
        var conf_input = document.getElementById("change_username_password");
            conf_input.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('submit_updateform').click();
                }
        });
        var enter_username = document.getElementById("new_username");
            enter_username.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    document.getElementById('proceed_butt').click();
                }
        });
        var passinputs = document.getElementsByClassName("pass_inputs");
            for(var i = 0; i < passinputs.length; i++) {
                passinputs[i].addEventListener("keydown", function (e) {
                    if (e.keyCode === 13) {
                        document.getElementById('changepass_submit').click();
                    }
                });
        }
        var createacctinputs = document.getElementsByClassName("create_inputs");
            for(var i = 0; i < createacctinputs.length; i++) {
                createacctinputs[i].addEventListener("keydown", function (e) {
                    if (e.keyCode === 13) {
                        document.getElementById('createinputs_proceed').click();
                    }
                });
        }
        var acctupdate_inputs = document.getElementsByClassName("acct_update");
            for(var i = 0; i < acctupdate_inputs.length; i++) {
                acctupdate_inputs[i].addEventListener("keydown", function (e) {
                    if (e.keyCode === 13) {
                        document.getElementById('acctupdate_submit').click();
                    }
                });
        }

        function confirm_password(form_id) {
            <?php
                $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
                $user = mysqli_query($conn, $user);
                $user = mysqli_fetch_assoc($user);
                $password = $user['password'];
            ?>
            var x = document.getElementById("change_username_password").value;
            if(x != "<?php echo $password ?>") {
                $.uiAlert({
                    textHead: "Wrong Password!",
                    text: 'Enter correct password to proceed',
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
            } else {
                document.getElementById(form_id).submit();
            }
        }

        function update_pass() {
            <?php
                $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
                $user = mysqli_query($conn, $user);
                $user = mysqli_fetch_assoc($user);
                $password = $user['password'];
            ?>
            var currp = document.getElementById('current_password');
            var newp = document.getElementById('new_password');
            var confp = document.getElementById('conf_password');
            if(currp.value != "<?php echo $password ?>") {
                currp.parentElement.classList.add("error");
                $.uiAlert({
                    textHead: "Wrong Password!",
                    text: 'Enter correct password to proceed',
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
            } else currp.parentElement.classList.remove("error");
            newp.parentElement.classList.remove("error");
            confp.parentElement.classList.remove("error");
            if(newp.value == '') {
                $.uiAlert({
                    textHead: "Enter new password!",
                    text: "Passwords may not be empty.",
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
                newp.parentElement.classList.add("error");
            } else if(confp.value == '') {
                $.uiAlert({
                    textHead: "Please confirm new password!",
                    text: "Enter the new password again",
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
                confp.parentElement.classList.add("error");
            } else if(newp.value != confp.value) {
                $.uiAlert({
                    textHead: "Does not match!",
                    text: "Passwords didn't match, try again.",
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
                newp.parentElement.classList.add("error");
                confp.parentElement.classList.add("error");
            } else {
                newp.parentElement.classList.remove("error");
                confp.parentElement.classList.remove("error");
                if(currp.value == "<?php echo $password ?>") document.getElementById("form_change_password").submit();
            }
        }

        function update_username(form_id) {
            $('#modal_username').modal({autofocus: true,}).modal('show');
            document.getElementById('back_confirm').setAttribute('onclick', "$('#modal_username').modal('show')");
            document.getElementById('submit_updateform').setAttribute('onclick', "confirm_password('form_change_username')");
        }

        function update_acct(username) {
            $('#modal_accounts').modal({autofocus: true,}).modal('show');
            document.getElementById('modalaccts_header').innerHTML = "Update Account :  &nbsp&nbsp" + username;
            document.getElementById('acct_username').setAttribute('value', username);
            document.getElementById('update_user').setAttribute('value', username);
            document.getElementById('back_confirm').setAttribute('onclick', "$('#modal_accounts').modal('show')");
            document.getElementById('submit_updateform').setAttribute('onclick', "confirm_password('form_update_account')");
        }

        function check_match(type) {
            if(type == 'accts') {
                var newp = document.getElementById('acct_new').value;
                var confp = document.getElementById('acct_conf').value;
            } else if(type == 'create') {
                var newp = document.getElementById('create_password').value;
                var confp = document.getElementById('create_conf').value;
            }
            if(newp != confp) {
                $.uiAlert({
                    textHead: "Does not match!",
                    text: "Passwords didn't match, try again.",
                    bgcolor: '#DB2828',
                    textcolor: '#fff',
                    position: 'top-center',
                    icon: 'remove circle',
                    time: 1,
                });
                if(type == 'accts') {
                    document.getElementById('acct_new').parentElement.classList.add("error");
                    document.getElementById('acct_conf').parentElement.classList.add("error");
                } else if(type == 'create') {
                    document.getElementById('create_password').parentElement.classList.add("error");
                    document.getElementById('create_conf').parentElement.classList.add("error");
                }
            } else {
                if(type == 'accts') {
                    document.getElementById('acct_new').parentElement.classList.remove("error");
                    document.getElementById('acct_conf').parentElement.classList.remove("error");
                } else if(type == 'create') {
                    document.getElementById('create_password').parentElement.classList.remove("error");
                    document.getElementById('create_conf').parentElement.classList.remove("error");
                }
                if(type == 'create') {
                    if(document.getElementById('create_username').value != '' && newp != '' && confp != '') $('#modal_confirm').modal({autofocus: true,}).modal('show');
                    else {
                        if(document.getElementById('create_username').value == '') document.getElementById('create_username').parentElement.classList.add("error");
                        else document.getElementById('create_username').parentElement.classList.remove("error");
                        if(newp == '') document.getElementById('create_password').parentElement.classList.add("error");
                        else document.getElementById('create_password').parentElement.classList.remove("error");
                        if(confp == '') document.getElementById('create_conf').parentElement.classList.add("error");
                        else document.getElementById('create_conf').parentElement.classList.remove("error");
                    }
                } else $('#modal_confirm').modal({autofocus: true,}).modal('show');
            }
        }

        function create_acct() {
            $('#modal_create').modal({autofocus: true,}).modal('show');
            document.getElementById('back_confirm').setAttribute('onclick', "$('#modal_create').modal('show')");
            document.getElementById('submit_updateform').setAttribute('onclick', "confirm_password('form_create')");
        }

        function delete_acct(id, username, type) {
            if(type == 'open') {
                $('#modal_delete').modal({autofocus: true,}).modal('show');
                document.getElementById('id_delete').setAttribute('value', id);
                document.getElementById('delete_header').innerHTML = "Delete Account :  &nbsp&nbsp" + username;
            } else {
                <?php
                    $user = "SELECT * FROM charles_table_users WHERE username='" . $_SESSION['username'] . "'";
                    $user = mysqli_query($conn, $user);
                    $user = mysqli_fetch_assoc($user);
                    $password = $user['password'];
                ?>
                var x = document.getElementById("delete_password").value;
                if(x != "<?php echo $password ?>") {
                    $.uiAlert({
                        textHead: "Wrong Password!",
                        text: 'Enter correct password to proceed',
                        bgcolor: '#DB2828',
                        textcolor: '#fff',
                        position: 'top-center',
                        icon: 'remove circle',
                        time: 1,
                    });
                } else {
                    document.getElementById('form_delete').submit();
                }
            }
        }
    </script>
<?php endblock() ?>