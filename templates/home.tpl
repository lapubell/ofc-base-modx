[[$HTML Head]]

<body class='page-home'>
[[$Header]]


<div id='main-content'>

    <div class='container'>

        [[*show-slider:is=`1`:then=`
            <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.cycle2/20140415/jquery.cycle2.min.js'></script>
            <div class='row'>
                <div class='cycle-wrapper'>

                    <div class='cycle-slideshow'
                        data-cycle-slides='>.slide'
                        data-cycle-next='.next'
                        data-cycle-prev='.prev'
                        data-cycle-pager='.cycle-pager'
                    >
                        
                        [[!getImageList?
                            &tvname=`slides`
                            &tpl=`Slider Slide cycle2`
                        ]]

                        <div class='next'><i class='fa fa-chevron-right'></i></div>
                        <div class='prev'><i class='fa fa-chevron-left'></i></div>
                        
                    </div>

                </div>

                <div class='cycle-pager'></div>
            </div>
        `]]

        <div class='row'>

            <div class='main-content-wrapper'>
                [[*content]]
            </div>

        </div>
    </div>

</div>


[[$HTML Foot]]