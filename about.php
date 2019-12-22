 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
        <link rel="stylesheet" href="./style/about.css">
    </head>
    <body>
        <script
            src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
        
        $(document).ready(function(){
     $(".hihi").hover(function() {
         $('.card').show();
       },function() {
        setTimeout(function() {
        if(!($('.hihi:hover').length > 0))
            $('.card').hide('slow');
        }, 3000);
    });   
 });

 function Hello()
 {
     alert('1232');
 }
        </script>
        <a  onmousedown="Hello()" href="" class="hihi">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo
            quisquam quae sed atque autem cum ullam? Magnam eaque nostrum earum
            repellendus nihil, molestiae esse eligendi unde similique debitis,
            consequatur quasi.
        </a>

        <div class="card">
            <div class="front">
                <img src="2.jpg" alt="">
            </div>
            <div class="back">
                <div class="details">
                    <h2>John Cena<br>
                        <span>Web designer</span>
                    </h2>
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                    <a href=""><i class="fab fa-google-plus-g"></i></a>
                </div>
            </div>
        </div>
    </body>
</html>