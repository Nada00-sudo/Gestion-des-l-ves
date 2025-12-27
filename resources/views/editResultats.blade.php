<x-appProf>
    <br>
    <br>
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow-md">
    
    <h2 class="text-xl font-bold mb-4">
        Modifier les notes – {{ $student->name }}
    </h2>

    <form method="POST" action="{{ route('resultats.update', $resultat->id) }}"
          class="grid grid-cols-2 gap-4">
        @csrf
        @method('PUT')

        <input type="number" name="note1" value="{{ $resultat->note1 }}" class="border p-2 rounded">
        <input type="number" name="note2" value="{{ $resultat->note2 }}" class="border p-2 rounded">
        <input type="number" name="note3" value="{{ $resultat->note3 }}" class="border p-2 rounded">
        <input type="number" name="note4" value="{{ $resultat->note4 }}" class="border p-2 rounded">
        <input type="number" name="note5" value="{{ $resultat->note5 }}" class="border p-2 rounded">

        <button  style="padding:8px 15px; background:#2ecc71; color:white; border:none;">
            Enregistrer
        </button>
    </form>
</div>
</x-appProf>
