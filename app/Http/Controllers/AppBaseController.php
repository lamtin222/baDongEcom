<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
/**
 * @OA\Server(url="/api")
 * @OA\Info(
 *   title="InfyOm Laravel Generator APIs",
 *   version="1.0.0"
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    protected $modelName='';

    public function sendResponse($result, $message)
    {
        return response()->json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404)
    {
        return response()->json(ResponseUtil::makeError($error), $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }

    public function handleUploadFile($request,$field)
    {
        if (!$request->hasFile($field)) {
            return;
        }

        $files = Arr::wrap($request->file($field));

        $filesPath = [];
        $path = $this->generatePath($this->modelName);

        foreach ($files as $file) {
            $filename = $this->generateFileName($file, $path);
            $file->storeAs(
                $path,
                $filename.'.'.$file->getClientOriginalExtension(),
                config('voyager.storage.disk', 'public')
            );

            array_push($filesPath, [
                'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return json_encode($filesPath);
    }
    public function handleUploadImage($request,$field)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $path = $this->modelName.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;
            $filename = $this->generateFileName($file, $path);
            $image = InterventionImage::make($file)->orientate();
            $fullPath = $path.$filename.'.'.$file->getClientOriginalExtension();
            $resize_width = $image->width();
            $resize_height = $image->height();
            $resize_quality =100;
            $image = $image->resize(
                $resize_width,
                $resize_height,
                function (Constraint $constraint) {
                    $constraint->aspectRatio();
                }
            )->encode($file->getClientOriginalExtension(), $resize_quality);
            if ($this->is_animated_gif($file)) {
                Storage::disk(config('voyager.storage.disk'))->put($fullPath, file_get_contents($file), 'public');
                $fullPathStatic = $path.$filename.'-static.'.$file->getClientOriginalExtension();
                Storage::disk(config('voyager.storage.disk'))->put($fullPathStatic, (string) $image, 'public');
            } else {
                Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public');
            }
            return $fullPath;
        }
    }
    /**
     * @return string
     */
    public function handleUploadMultipleImage($request, $field)
    {
        $filesPath = [];
        $files = $request->file($field);

        if (!$files) {
            return [];
        }

        foreach ($files as $index=>$file) {

            if (!$file->isValid()) {

                continue;
            }
            $image = InterventionImage::make($file)->orientate();
            $resize_width = $image->width();
            $resize_height = $image->height();
            $resize_quality = 100;

            $filename = Str::random(20);
            $path =$this->modelName.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;
            array_push($filesPath, $path.$filename.'.'.$file->getClientOriginalExtension());
            $filePath = $path.$filename.'.'.$file->getClientOriginalExtension();

            $image = $image->resize(
                $resize_width,
                $resize_height,
                function (Constraint $constraint) {
                    $constraint->aspectRatio();
                }
            )->encode($file->getClientOriginalExtension(), $resize_quality);

            Storage::disk(config('voyager.storage.disk'))->put($filePath, (string) $image, 'public');

        }

        return json_encode($filesPath);
    }

    /**
     * @return string
     */
    protected function generatePath()
    {
        return $this->modelName.DIRECTORY_SEPARATOR.date('FY').DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    protected function generateFileName($file, $path)
    {
            $filename = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $filename=Str::slug($filename);
            $filename_counter = 1;
            // Make sure the filename does not exist, if it does make sure to add a number to the end 1, 2, 3, etc...
            while (Storage::disk(config('voyager.storage.disk'))->exists($path.$filename.'.'.$file->getClientOriginalExtension())) {
                $filename = basename(Str::slug($file->getClientOriginalName()), '.'.$file->getClientOriginalExtension()).(string) ($filename_counter++);
                $filename=Str::slug($filename);
            }

        return $filename;
    }
    /**
     * @return Bool
     */
    private function is_animated_gif($filename)
    {
        $raw = file_get_contents($filename);
        $offset = 0;
        $frames = 0;
        while ($frames < 2) {
            $where1 = strpos($raw, "\x00\x21\xF9\x04", $offset);
            if ($where1 === false) {
                break;
            } else {
                $offset = $where1 + 1;
                $where2 = strpos($raw, "\x00\x2C", $offset);
                if ($where2 === false) {
                    break;
                } else {
                    if ($where1 + 8 == $where2) {
                        $frames++;
                    }
                    $offset = $where2 + 1;
                }
            }
        }
        return $frames > 1;
    }

    public function removeFile($path)
    {
        if(!is_null($path) || $path!="")
       { if(Storage::disk(config('voyager.storage.disk'))->exists($path))
        {
            Storage::disk(config('voyager.storage.disk'))->delete($path);
        }}
    }
    // processing
    public function remove_media(Request $request)
    {
        try {
            #region collect data
            // GET THE SLUG, ex. 'posts', 'pages', etc.
            $slug = $request->get('slug');

            // GET file name
            $filename = $request->get('filename');

            // GET record id
            $id = $request->get('id');

            // GET field name
            $field = $request->get('field');

            // GET multi value
            $multi = $request->get('multi');

            $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

            // Load model and find record
            $model = app($dataType->model_name);
            $data = $model::find([$id])->first();

            // Check if field exists
            if (!isset($data->{$field})) {
                throw new Exception(__('voyager::generic.field_does_not_exist'), 400);
            }
            #endregion


            // Check permission
            // $this->authorize('edit', $data);

            #region proceed data
            if (@json_decode($multi)) {
                // Check if valid json
                if (is_null(@json_decode($data->{$field}))) {
                    throw new Exception(__('voyager::json.invalid'), 500);
                }

                // Decode field value
                $fieldData = @json_decode($data->{$field}, true);
                $key = null;

                // Check if we're dealing with a nested array for the case of multiple files
                if (is_array($fieldData[0])) {
                    foreach ($fieldData as $index=>$file) {
                        // file type has a different structure than images
                        if (!empty($file['original_name'])) {
                            if ($file['original_name'] == $filename) {
                                $key = $index;
                                break;
                            }
                        } else {
                            $file = array_flip($file);
                            if (array_key_exists($filename, $file)) {
                                $key = $index;
                                break;
                            }
                        }
                    }
                } else {
                    $key = array_search($filename, $fieldData);
                }

                // Check if file was found in array
                if (is_null($key) || $key === false) {
                    throw new Exception(__('voyager::media.file_does_not_exist'), 400);
                }

                $fileToRemove = $fieldData[$key]['download_link'] ?? $fieldData[$key];

                // Remove file from array
                unset($fieldData[$key]);

                // Generate json and update field
                $data->{$field} = empty($fieldData) ? null : json_encode(array_values($fieldData));
            } else {
                if ($filename == $data->{$field}) {
                    $fileToRemove = $data->{$field};

                    $data->{$field} = null;
                } else {
                    throw new Exception(__('voyager::media.file_does_not_exist'), 400);
                }
            }

            $row = $dataType->rows->where('field', $field)->first();

            // Remove file from filesystem
            if (in_array($row->type, ['image', 'multiple_images'])) {
                $this->deleteBreadImages($data, [$row], $fileToRemove);
            } else {
                $this->removeFile($fileToRemove);
            }

            $data->save();
            #endregion
            return response()->json([
                'data' => [
                    'status'  => 200,
                    'message' => __('voyager::media.file_removed'),
                ],
            ]);
        } catch (Exception $e) {
            $code = 500;
            $message = __('voyager::generic.internal_error');

            if ($e->getCode()) {
                $code = $e->getCode();
            }

            if ($e->getMessage()) {
                $message = $e->getMessage();
            }

            return response()->json([
                'data' => [
                    'status'  => $code,
                    'message' => $message,
                ],
            ], $code);
        }
    }


    /**
     * Delete all images related to a BREAD item.
     *
     * @param \Illuminate\Database\Eloquent\Model $data
     * @param \Illuminate\Database\Eloquent\Model $rows
     *
     * @return void
     */
    public function deleteBreadImages($data, $rows, $single_image = null)
    {
        $imagesDeleted = false;

        foreach ($rows as $row) {
            if ($row->type == 'multiple_images') {
                $images_to_remove = json_decode($data->getOriginal($row->field), true) ?? [];
            } else {
                $images_to_remove = [$data->getOriginal($row->field)];
            }

            foreach ($images_to_remove as $image) {
                // Remove only $single_image if we are removing from bread edit
                if ($image != config('voyager.user.default_avatar') && (is_null($single_image) || $single_image == $image)) {
                    $this->removeFile($image);
                    $imagesDeleted = true;


                }
            }
        }
    }
}
