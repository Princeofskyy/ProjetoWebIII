
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamburgueria QI Delicia</title>
    <link rel="stylesheet" href="./css/info.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="content">
        <header>
            <h1>Hamburgueria QI Delicia</h1>
            <a href="./login_cliente.php" class="login">Login</a>
        </header>
    </div>
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./imagens/lanchebom.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Hambúrguer Artesanal</h5>
                    <p>O primeiro hambúrguer artesanal de qualidade feito com blend de carnes nobres em Sapucaia do Sul.
                    </p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./imagens/lanche.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Suculência</h5>
                    <p>Nossos blends de carne sempre ao ponto com a suculência que todo apreciador de hambúrguer merece.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="./imagens/combo.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Combos Imperdéveis.</h5>
                    <p>Nossa Hamburgueria oferece o melhor custo benefício para que sua família possa vivenciar a experiência completa.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="sobre">
        <div class="container">
            <h2>Sobre a QI Delícia</h2>
            <p>A Hamburgueria QI Delícia é o primeiro estabelecimento de Sapucaia do Sul a oferecer hambúrgueres
                artesanais de alta qualidade. Nosso cardápio é cuidadosamente elaborado com ingredientes selecionados
                para proporcionar a melhor experiência gastronômica.</p>
        </div>
    </section>

    <section class="localizacao">
        <div id="contact-info">
            <h3>Localização</h3>
            <p>Estamos localizados em R. Vinte e Cinco de Julho, 564 - Vargas, Sapucaia do Sul - RS, 93222-000</p>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3461.6388657357957!2d-51.14190792513813!3d-29.81697592076427!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95196f2a593c6151%3A0xee0be7c4a3eba933!2sCol%C3%A9gio%20ULBRA%20S%C3%A3o%20Lucas!5e0!3m2!1spt-BR!2sbr!4v1702940466733!5m2!1spt-BR!2sbr"
                width="400" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <p>Telefone: (51) 3400-9999</p>
            <p>Email: contato@QIDelicia.com</p>

            <!-- Links para Instagram e WhatsApp -->
            <p>
                Siga-nos:
                <a href="https://www.instagram.com/sensibily" target="_blank">Instagram</a> |
                <a href="https://wa.me/551112345678" target="_blank">WhatsApp</a>
            </p>


        </div>
    </section>

    <footer>
        <p>&copy; 2024 Hamburgueria QI Delicia. Todos os direitos reservados.</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>

</html>