<div class="modal fade" id="st-login-form" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="max-width: 450px;">
        <div class="modal-content relative">
            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                </button>
                <h4 class="modal-title"><?php echo esc_html__('Log In', 'traveler') ?></h4>
            </div>
            <div class="modal-body relative">
                <form action="" class="form" method="post">
                    <input type="hidden" name="st_theme_style" value="modern"/>
                    <input type="hidden" name="action" value="st_login_popup">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" autocomplete="off"
                               placeholder="<?php echo esc_html__('Email or Username', 'traveler') ?>">
                               <?php echo TravelHelper::getNewIcon('ico_email_login_form', '', '18px', ''); ?>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" autocomplete="off"
                               placeholder="<?php echo esc_html__('Password', 'traveler') ?>">
                               <?php echo TravelHelper::getNewIcon('ico_pass_login_form', '', '16px', ''); ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="form-submit"
                               value="<?php echo esc_html__('Log In', 'traveler') ?>">
                    </div>
                    <div class="message-wrapper mt20"></div>
                    <div class="mt20 st-flex space-between st-icheck">
                        <div class="st-icheck-item">
                            <label for="remember-me" class="c-grey">
                                <input type="checkbox" name="remember" id="remember-me"
                                       value="1"> <?php echo esc_html__('Remember me', 'traveler') ?>
                                <span class="checkmark fcheckbox"></span>
                            </label>
                        </div>
                        <a href="" class="st-link open-loss-password"
                           data-toggle="modal"><?php echo esc_html__('Forgot Password?', 'traveler') ?></a>
                    </div>
                    <div class="advanced">
                        <p class="text-center f14 c-grey"><?php echo esc_html__('or continue with', 'traveler') ?></p>
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                <?php if (st_social_channel_status('facebook')): ?>
                                    <a onclick="return false" href="#"
                                       class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                           <?php echo TravelHelper::getNewIcon('fb', '', '100%') ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <?php if (st_social_channel_status('google')): ?>
                                    <a href="javascript: void(0)" id="st-google-signin2"
                                       class="btn_login_gg_link st_login_social_link" data-channel="google">
                                           <?php echo TravelHelper::getNewIcon('g+', '', '100%') ?>
                                    </a>
                                    <!--<div id="st-google-signin2" class="btn_login_gg_link st_login_social_link"></div>-->
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-4 col-sm-4">
                                <?php if (st_social_channel_status('twitter')): ?>
                                    <a href="<?php echo site_url() ?>/social-login/twitter"
                                       onclick="return false"
                                       class="btn_login_tw_link st_login_social_link" data-channel="twitter">
                                           <?php echo TravelHelper::getNewIcon('tt', '', '100%') ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt20 c-grey font-medium f14 text-center">
                        <?php echo esc_html__('Do not have an account? ', 'traveler') ?>
                        <a href=""
                           class="st-link open-signup"
                           data-toggle="modal"><?php echo esc_html__('Sign Up', 'traveler') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>