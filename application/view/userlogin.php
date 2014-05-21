 <!DOCTYPE html>
    <html>
    <head>
        <base href="<?=AppConfig::BASE_URL?>">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" >
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>高德CPR统计</title>
        <link rel="stylesheet" type="text/css" href="css/main-blue.css" />
        <style># ui-datepicker-div{font-size:62%;}</style>
        <link rel="Shortcut Icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" type="image/x-icon" />
        <script src="js/jquery.min.js"></script>    
        <style>
            body{background-color: #a3a0ff;}
            .signin-box{
                width: 415px;
                height: 311px;
                border-radius: 5px;
                background:-webkit-gradient(linear, 0 0, 0 bottom, from(#EEEEEE), to(rgba(204,204,204, 0.5)));
                position: absolute;
                left:50%;
                top:50%;
                margin-left: -205px;
                margin-top: -205px;
                /*margin: auto;*/
                background: url(img/login-line.jpg);
            }
            .signin-box fieldset{border: none;}
            .signin-box input{
                width: 339px;
                height: 35px;
                border-radius: 3px;
                font-size: 20px;
                border: 1px solid #9AB2CA;
                border-right-color: #C3D3E3;
                border-bottom-color: #C3D3E3;
            }
            .signin-box form{
                margin-top: 33px;
            }
            .signin-box fieldset{height: 200px;}
            .form-line{height: 46px; text-align: center;}
            .form-line-btn{
                text-align: center;
                top: 240px;
                /*
                position: absolute;
                margin-left: 21px;
                */
                top: 5px;
                position: relative;
            }
            .form-line-btn button{width: 339px;height: 34px; border: 1px solid #1F54BC;
                color: white; background: url(img/login-btn-line.png);background-position: -1px;
                font-size: 14px; font-weight: bold;
            }
            .login-header{text-align: center; height: 72px; }
            .login-header img{margin-top: 23px;}
            .login-line{height: 1px;width: 406px; margin: auto; border-top: 1px solid #1381C6; border-bottom: 1px solid #9DDBF5}
            .login-error{margin-left: 38px; color: #FCFF00;height: 18px;}
        </style>
    </head>
    <body>
    <div class="signin-box">
        <div class="login-header">CPR数据组报表系统</div>
        <div class="login-line"></div>
        <form method="post" id="login-form" action="user/check">
            <fieldset>
                <legend></legend>
                <div class="form-line">
                    <input type="text" name="loginname" id="loginname" placeholder="用户名"/>
                </div>
                <div class="form-line">
                    <input type="password" name="pwd" id="pwd" placeholder="登录密码"/>
                </div>
                <div class="login-error"></div>
                <div class="form-line-btn">
                    <button type="submit" class="btn">登&nbsp;&nbsp;录</button>
                </div>
            </fieldset>
        </form>
    </div>        
    </body>
    </html>