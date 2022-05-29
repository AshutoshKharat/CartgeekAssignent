<div class="sidenav-container" id="side-nav">
    <nav class="nav">
        <div class="nav__brand">
            <div class="nav__icon nav__icon--menu" id="nav-toggle">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <span href="#" class="nav__brand-logo">CratGeek</span>
        </div>

        <!-- <hr> -->

        <ul class="nav__list">
            <li class="nav__item">
                <a href="{{ url('/ShowProducts') }}" class="nav__link active">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span class="nav__name">Product Master</span>
                </a>
            </li>
        </ul>
        <hr>
    </nav>
</div>

<script>
    $(document).ready(function() {
        $(".js-example-basic-single").select2();
        $('.js-example-basic-multiple').select2();
    });
</script>

</html>
