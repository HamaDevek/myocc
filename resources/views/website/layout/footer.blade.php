<footer id="footer" class="page-footer pink lighten-5">
    <div class="container">
        <div class="row">

            <div class="col l4 offset-l2 s12">
                <h5 class="black-text">Links</h5>
                <ul>
                    <li><a class="black-text text-lighten-3" href="#!">Link 1</a></li>
                    <li><a class="black-text text-lighten-3" href="#!">Link 2</a></li>
                    <li><a class="black-text text-lighten-3" href="#!">Link 3</a></li>
                    <li><a class="black-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
            </div>
            <div class="col l6 s12 right-align">
                <h5 class="black-text">{{$footer->footer_title}}</h5>
                <p class="black-text text-lighten-4">{{$footer->footer_desc}}</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container black-text center-align">
            © {{now()->year}} My Occassions

        </div>
    </div>
</footer>