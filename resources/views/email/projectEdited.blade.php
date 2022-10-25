<div>Tisztelt Kapcsolattartó!</div>

<div>A {{$project->id}} azonosítójú projekten változások történtek!</div>

<div>Projekt neve: {{$project->name}}</div>

<div>Projekt leírása: {{$project->description}}</div>

<div>Kapcsolattartók:</div>

@foreach($project->contacts as $contact)
<div>{{$contact->name}}</div>
<div>{{$contact->email}}</div>
@endforeach