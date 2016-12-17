


    <style>
        ul.q_a { margin: 0; padding: 0; }
        ul.q_a li { position: relative; width: 240px; height: 24px;  }
        li { list-style-type: none; }
        .SearchFilter { padding-top: 3px; padding-left: 3px; width: 230px; height: 14px;  }
        .FilterOption { border-left: 1px solid gray; color: #a9d95f; cursor: pointer; float: left;
                        font-family: Tahoma, sans-serif; font-size: 11px; text-align: center; min-width: 35px;
                        height: 14px; background: url("narrow-bg-on.png") repeat-x; }
        .FilterOption.On { color: #555; background: url("narrow-bg-off.png") repeat-x; }
        .FilterLeftCorners { border-top-left-radius: 3px; border-bottom-left-radius: 3px; }
        .FilterRightCorners { border-top-right-radius: 3px; border-bottom-right-radius: 3px; }
     </style>


                <div style = "position: relative; height: 30px; background: url('search-bar.png') no-repeat;">
                    <input
                           id = "filter_q"
                      onkeyup = "filter()"
                         type = "text"
                        style = "border: 0px; position: absolute; top: 5px; left: 38px; width: 180px; height: 17px"/>
                </div>
                
                <div style = "height: 21px; background: silver;">
                    <div class = "SearchFilter">
                        <div index = "0" class = "FilterOption On FilterLeftCorners">Page</div>
                        <div index = "1" class = "FilterOption On">Blog</div>
                        <div index = "2" class = "FilterOption">Draft</div>
                        <div index = "3" class = "FilterOption FilterRightCorners" style = "min-width: 32px">Del</div>
                    </div>
                </div>