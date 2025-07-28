<x-mail::message>
# 🚨 Panic Alert

**Camera:** {{ $camera->name }}  
**Stream Type:** {{ $camera->protocol ?? 'N/A' }}  
**Status:** Offline  
**Group:** {{ $group->name }}

The camera mentioned above is currently offline. Since panic alerts are enabled for this group, please investigate the issue immediately.

<x-mail::button :url="url('my-cameras/view/' . $camera->id)">
View Camera Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
