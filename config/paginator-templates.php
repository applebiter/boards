<?php 

return [
    'nextActive' => '<li class="page-item">
                       <a class="page-link" href="{{url}}">{{text}}</a>
                     </li>',
    'nextDisabled' => '<li class="page-item disabled">
                       <a class="page-link" href="{{url}}">{{text}}</a>
                     </li>',
    'prevActive' => '<li class="page-item">
                       <a class="page-link" href="{{url}}">{{text}}</a>
                     </li>',
    'prevDisabled' => '<li class="page-item disabled">
                         <a class="page-link" href="{{url}}">{{text}}</a>
                       </li>',
    'counterRange' => '{{start}} - {{end}} of {{count}}',
    'counterPages' => 'Page {{page}} of {{pages}}, showing {{current}} sounds out of {{count}}',
    'first' => '<li class="page-item">
                  <a class="page-link" href="{{url}}">{{text}}</a>
                </li>',
    'last' => '<li class="page-item">
                 <a class="page-link" href="{{url}}">{{text}}</a>
               </li>',
    'number' => '<li class="page-item">
                 <a class="page-link" href="{{url}}">{{text}}</a>
               </li>',
    'current' => '<li class="page-item active">
                 <a class="page-link" href="{{url}}">{{text}}</a>
               </li>',
    'limit' => '<select name="limit" onChange="this.form.submit()" id="limit">{{text}}</select>',
];

