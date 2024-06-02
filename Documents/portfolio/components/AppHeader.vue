<template>
    <header class="header_area">
        <div class="main_menu">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <NuxtLink to="/" class="navbar-brand logo_h"><img src="~/assets/images/logo.png" alt=""></NuxtLink>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                        <ul class="nav navbar-nav menu_nav justify-content-end">

                            <li class="nav-item active">
                                <nuxt-link to="/" class="nav-link">Home</nuxt-link>
                            </li>
                            <li class="nav-item">
                                <nuxt-link to="about" class="nav-link">About</nuxt-link>
                            </li>
                            <li class="nav-item">
                                <nuxt-link to="services" class="nav-link">Services</nuxt-link>
                            </li>
                            <li class="nav-item">
                                <nuxt-link to="portfolio" class="nav-link">Portfolio</nuxt-link>
                            </li>
                            <li class="nav-item">
                                <nuxt-link to="contact" class="nav-link">Contact</nuxt-link>
                            </li>
                            <li class="nav-item">
                                <nuxt-link to="blogs" class="nav-link">Blogs</nuxt-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>