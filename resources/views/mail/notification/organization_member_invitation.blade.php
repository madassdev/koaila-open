<x-mail::message>
{{__('organization_member_invitation_email.intro', ['company_name'=>$user->company_name])}} 
<br/>
{{__('organization_member_invitation_email.login_info')}}
<x-mail::panel>
    <div>
        <p>
            {{__('organization_member_invitation_email.email')}} <strong>{{$user->email}}</strong>
        </p>
        <p>
            {{__('organization_member_invitation_email.password')}} <strong>{{$generated_password}}</strong>
        </p>
    </div>
</x-mail::panel>

{{__('organization_member_invitation_email.password_warning')}}

<x-mail::button :url="url(route('login'))">
    Login to dashboard
</x-mail::button>

</x-mail::message>
