<?php

namespace App\Http\Resources;

use App\Enums\CourtStageType;
use Illuminate\Http\Resources\Json\JsonResource;

class CourtCaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'case_no' => $this->case_no,
            'court_pronouncement' => $this->court_pronouncement,
            'is_case_closed' => $this->is_case_closed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'caseStatus' => new CaseStatusResource($this->whenLoaded('caseStatus')),
            'handler' => new UserResource($this->whenLoaded('handler')),
            'solicitor' => new SolicitorResource($this->whenLoaded('solicitor')),
            'postedBy' => new UserResource($this->whenLoaded('postedBy')),
            'caseActivities' => CaseActivityCollection::make($this->whenLoaded('caseActivities')),
            'suitParties' => SuitPartyCollection::make($this->whenLoaded('suitParties')),
            'legalDocuments' => LegalDocumentCollection::make($this->whenLoaded('legalDocuments')),
            'caseRequest' => new CaseRequestResource($this->whenLoaded('caseRequest')),
            'court_judgement' => $this->court_judgement,
            'court_stage' => $this->court_stage,
            'has_moved' => $this->has_moved,
            'court_stage_label' => $this->computeCourtStageLabel($this->court_stage),
            'judgement_document_file' => filter_var($this->memo_file, FILTER_VALIDATE_URL) ? $this->judgement_document_file : (is_null($this->judgement_document_file) ? null : config('app.url') . '/file/get/' . $this->judgement_document_file),
        ];
    }

    public function computeCourtStageLabel(int $courtStage)
    {
        if ($courtStage == CourtStageType::TRIAL_COURT) {
            return 'Trial Court';
        } elseif ($courtStage == CourtStageType::APPEAL_COURT) {
            return 'Appeal Court';
        } elseif ($courtStage == CourtStageType::FINAL_COURT) {
            return 'Final Appeal Court';
        } else {
            return 'Pending';
        }
    }
}
