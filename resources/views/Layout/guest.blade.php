    @props(['title'=>'','bodyClass'=>'','socialAuth'=>true])
    <x-base-layout :$title :$bodyClass>
                    {{-- This slot to replace it by form each in signup or login page --}}
                    {{$slot}}
                    
    </x-base-layout>