<extends path="layout/app"/>

<block:content>
    <section class="section-top" id="home-top">
        <div class="container">
            <h1>Polis Parallèle <br> France</h1>

            <h2 class="h3">Crypto Anarchisme - Bitcoin - Texte</h2>
        </div>
    </section>

    <section id="section-about">
        <div class="container text-center">
            <h3 class="section-title">A propos</h3>
            <p class="my-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur animi tempora qui <br> quos, cumque quod dolorum illo, iure placeat? Corporis asperiores quaerat magnam unde !</p>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-users"></i>
                            <h4>Communauté</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab?</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fab fa-codepen"></i>
                            <h4>Technologie</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab?</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <i class="fas fa-mask"></i>
                            <h4>Crypto-anarchisme</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-bg1">

    </section>

    <section id="section-blog">
        <div class="container">
            <h3 class="section-title">Blog</h3>
            @if($posts)
            <?php foreach ($posts as $post): ?>
                <div class="card">
                    @if($post->image)
                        <div>
                            <a href="/blog/{{ $post->slug }}">
                                <img src="{{ $post->image }}" alt="article image" class="img-fluid">
                            </a>
                        </div>
                    @endif
                    <div class="card-body">
                        <h4>
                            <a href="/blog/{{ $post->slug }}">
                                {{ $post->title ?? '' }}
                            </a>
                        </h4>
                        <p>
                            {{ $post->preview }}
                        </p>
                        <a href="/blog/{{ $post->slug }}" class="btn btn-primary">
                            Lire la suite
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
            @else
                Pas d'article pour le moment
            @endif
        </div>
    </section>

    <section class="section-bg1">
        
    </section>

    <section id="section-events">
        <div class="container">
            <div class="section-title">Events</div>
        </div>
    </section>

    <section>
        <div class="container">
            <h3 class="section-title">Support</h3>
        </div>
    </section>
</block:content>