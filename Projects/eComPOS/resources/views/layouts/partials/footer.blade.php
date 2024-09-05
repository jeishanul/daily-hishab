<div class="app-wrapper-footer">
    <div class="app-footer">
        <div class="app-footer-inner">
            <div>
                © {{ getSettings('copyright_text') ?? '' }} <a class="razinsoftText"
                    href="{{ getSettings('copyright_url') ?? '' }}"
                    target="blank">{{ getSettings('developed_by') ?? '' }}.</a>
            </div>
            <div class="d-none d-sm-block">
                <i class="fa-solid fa-phone"></i>
                <span>{{ getSettings('phone') ?? '+8801714231625' }}</span>
            </div>
            <div class="d-none d-sm-block">
                <i class="fa-solid fa-envelope mr-1"></i>
                <span>{{ getSettings('email') ?? 'razinsoftltd@gmail.com' }}</span>
            </div>
        </div>
    </div>
</div>
