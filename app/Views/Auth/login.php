
            <main class='container'>
                <section>
                    <div>
                        <h1 class='text-center'>Simy Framework - Login </h1>
                        <form  action="/auth/login" method="post">
                            <div>
                                <label for='email-address'>
                                    Email address
                                </label>
                                <input
                                    id='email-address'
                                    name='email'
                                    type='email'
                                    required
                                    placeholder='Email address'
                                />
                            </div>

                            <div>
                                <label for='password'>Password</label>
                                <input
                                    id='password'
                                    name='password'
                                    type='password'
                                    required
                                    placeholder='Password'
                                />
                            </div>
                            <div>
                                <button>Login</button>
                            </div>
                        </form>

                        <p class='text-sm text-center'>
                            No account ye?
                            <NavLink to='/signup'>Sign up</NavLink>
                        </p>
                    </div>
                </section>
            </main>
        