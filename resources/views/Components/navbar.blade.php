<div class="navbarShop sticky">
    <nav class="nav-shop">
        <div class="koszykM">
            <a href="{{ route('cart') }}">
                <div class="koszyk">
                    Koszyk&nbsp;
                    <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                    <span class="basketItemCount"></span>
                </div>
            </a>
        </div>
        <!-- Checkbox for toggling menu -->
        <input type="checkbox" id="checkM">
        <!-- Menu icon -->
        <label for="checkM" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <ul>
            <li>
                <a href="https://osmolecko.pl">O nas</a>
            </li>
            <li>
                <a href="{{ route('showStatute') }}">Regulamin</a>
            </li>
            <li>
                <a href="{{ route('showContact') }}">Kontakt</a>
            </li>
            <li>
                <a href="{{ route('shop') }}">Sklep</a>
            </li>
            <li class="koszyk1">
                <a href="{{ route('cart') }}">
                    <div class="koszyk">
                        Koszyk&nbsp;
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                        <span class="basketItemCount"></span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>
