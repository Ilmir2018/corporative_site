@extends(env('THEME') . '.layouts.site');

@section('content')


    <div id="content-home" class="content group">
        <div class="hentry group">

            <form id="contact-form-contact-us" class="contact-form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <fieldset>
                    <ul>
                        <li class="text-field">
                            <label for="login">
                                <span class="label">Name</span><br>
                                <span class="sublabel">This is the name</span><br>
                            </label>
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-user"></i></span>
                                <input type="text" id="login" name="login" class="required">
                            </div>
                        </li>
                        <li class="text-field">
                            <label for="password">
                                <span class="label">Password</span><br>
                                <span class="sublabel">This is the name</span><br>
                            </label>
                            <div class="input-prepend">
                                <span class="add-on"><i class="icon-lock"></i></span>
                                <input type="text" id="password" name="password" class="required">
                            </div>
                        </li>
                        <li class="submit-button">
                            <input type="submit" name="yit-sendmail" value="Отправить" class="sendmail">
                        </li>
                    </ul>
                </fieldset>
            </form>
        </div>
    </div>



@endsection
