<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \Carbon\Carbon;

use \App\Manga;
use \App\MangaInformation;
use \App\Genre;
use \App\GenreInformation;
use \App\MangaUpdates;

class MangaInformationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $manga = Manga::find($id);
        $manga_info = MangaInformation::find($id);
        $genre_count = Genre::count();

        // update genres if there are none or if they are older than 6 months
        if ($genre_count == 0) {

            $genres = MangaUpdates::genres();
            Genre::populate($genres);
        } else {

            $oldest = Genre::oldest();
            if ($oldest != null && Carbon::now()->subMonths(6)->gt($oldest['updated_at'])) {

                $genres = MangaUpdates::genres();
                Genre::populate($genres);
            }
        }

        // Do we need to retrieve information from mangaupdates?
        if ($manga_info == null) {
            // Yes
            $manga_info = MangaInformation::createFromMangaUpdates($manga->getId(), $manga->getName());

            if ($manga_info != null)
                $manga_info->save();
        }

        $name = $manga->getName();
        $archives = $manga->getArchives();

        // These are passed to the blade template even if there is no MU information
        $mu_id = null;
        $description = null;
        $type = null;
        $assoc_names = null;
        $genres = null;
        $authors = null;
        $artists = null;
        $year = null;

        // Update the values if there is MU information
        if($manga_info != null) {
            $mu_id = $manga_info->getMangaUpdatesId();
            $description = $manga_info->getDescription();
            $type = $manga_info->getType();
            $assoc_names = $manga_info->getAssociatedNames();
            $genres = $manga_info->getGenres();
            $authors = $manga_info->getAuthors();
            $artists = $manga_info->getArtists();
            $year = $manga_info->getYear();
        }

        return view('manga.information', compact('id',
                                                 'mu_id',
                                                 'name',
                                                 'description',
                                                 'type',
                                                 'assoc_names',
                                                 'genres',
                                                 'authors',
                                                 'artists',
                                                 'year',
                                                 'archives'));
    }

    public function update(Request $request) {
        // Ensure the form data is valid
        $this->validate($request, [
            'id' => 'integer|required',
            'name' => 'string',
            'mu_id' => 'integer'
        ]);

        $id = \Input::get('id');
        $name = \Input::get('name');
        $mu_id = \Input::get('mu_id');

        $manga_info = MangaInformation::find($id);
        if ($manga_info != null)
            // this can fail; find a way to forward errors to MangaInformationController@index
            $manga_info->updateFromMangaUpdates($mu_id);

        return \Redirect::action('MangaInformationController@index', [$id]);
    }
}
