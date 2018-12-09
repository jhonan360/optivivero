<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="css/bootstrap-without-icons.min.css" >//aca 09/12/2018

    @yield('title')

    <style>
    .cuadrado {
        width: 45px;
        height: 20px;
        border: 1px solid #555;
    }
    @page { margin: 130px 50px; }
    @page {
        margin-right: 1,5cm;
        margin-left: 1,8cm;
    }
    #header { position: fixed; left: 0px; top: -140px;  right: 0px; height: 10;  text-align: center; }
    #footer { position: fixed; left: 0px; bottom: -150px; right: 0px; height: 130px;  }
    #footer .page:after { content: counter(page, upper-roman); }
</style>


@yield('styles')

</head>
<body id="app-layout">

    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                   <!-- <img src="img/header.jpg"  width="110%"></img>-->
                   <h1>prueba</h1>
                </div>
                
            </div>
        </div>
        @yield('header')
    </header>
    <footer id="footer">
        <div class="container">
                    <!--<img src="img/footer.jpg"  width="95%"></img>-->
                <p>
                    
                </p>

              <hr style="height: 2px; width: 100%; background-color: black; margin-bottom: 0px; margin-top: 0px;" align="right">
              <font size=-4>
                  Fecha: {{date('Y-m-d H:i:s')}}
              </font>
          </hr>
      </div>
      @yield('footer')
  </footer>

  @yield('body')

  @yield('scripts')

</body>
</html>
