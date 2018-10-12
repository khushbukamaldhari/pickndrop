Hello <i>{{ $demo->username }}</i>,
<p>Please <a href="{{  url( '/user/verify/' . $demo->id . '/' . $demo->type . '/' . $demo->link )  }}">Click Here </a> to activate your account</p>
