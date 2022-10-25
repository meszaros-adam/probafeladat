Tisztelt Kapcsolattartó! 

A {{$project->name}} nevű projecten az alábbi változások történtek!

@foreach($changes as $change)
    {{$project->$change}}
@endforeach

